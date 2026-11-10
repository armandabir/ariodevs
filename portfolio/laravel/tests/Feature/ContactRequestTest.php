<?php

namespace Tests\Feature;

use App\Models\ContactRequest;
use App\Models\User;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
            'email' => 'visitor@example.com',
            'message' => '<script>alert("x")</script>',
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('contact_requests', [
            'name' => 'Test Visitor',
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
}