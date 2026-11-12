<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\ContactRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class ContactRequestTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(VerifyCsrfToken::class);
    }

    public function test_contact_request_is_saved_and_shown_in_private_inbox(): void
    {
        $response = $this->postJson('/contact-requests', [
            'name' => 'Test Visitor',
            'phone' => '09120000000',
            'email' => 'visitor@example.com',
            'message' => '<script>alert("x")</script>',
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('contact_requests', [
            'name' => 'Test Visitor',
            'phone' => '09120000000',
            'email' => 'visitor@example.com',
            'message' => '<script>alert("x")</script>',
        ]);

        $inbox = $this->actingAs(User::factory()->make())->get('/dashboard/contact-requests');

        $inbox->assertOk()
            ->assertSee('Test Visitor')
            ->assertSee('visitor@example.com')
            ->assertSee('&lt;script&gt;alert(&quot;x&quot;)&lt;/script&gt;', false);
    }

    public function test_contact_request_requires_valid_fields(): void
    {
        $this->postJson('/contact-requests', [
            'name' => '',
            'email' => 'not-an-email',
            'message' => '',
        ])->assertUnprocessable();

        $this->assertSame(0, ContactRequest::count());
    }

    public function test_whatsapp_messages_are_sent_to_sender_and_owner_after_submit(): void
    {
        config([
            'services.whatsapp.token' => 'test-token',
            'services.whatsapp.phone_number_id' => '12345',
            'services.whatsapp.owner_number' => '+989361811998',
        ]);
        RateLimiter::clear('contact-requests');
        Http::fake(['graph.facebook.com/*' => Http::response(['messages' => [['id' => 'wamid']]], 200)]);

        $this->postJson('/contact-requests', [
            'name' => 'Ali',
            'phone' => '+98 912 000 0000',
            'email' => 'ali@example.com',
            'message' => 'Hi',
        ])->assertCreated();

        Http::assertSentCount(2);
        Http::assertSent(fn ($request) => $request['to'] === '989120000000' && $request['type'] === 'template');
        Http::assertSent(fn ($request) => $request['to'] === '989361811998');
    }

    public function test_contact_request_still_succeeds_when_whatsapp_is_not_configured(): void
    {
        config(['services.whatsapp.token' => null, 'services.whatsapp.phone_number_id' => null]);
        Http::fake();

        $this->postJson('/contact-requests', [
            'name' => 'Ali',
            'phone' => '09120000000',
            'email' => 'ali@example.com',
            'message' => 'Hi',
        ])->assertCreated();

        Http::assertNothingSent();
    }
}
