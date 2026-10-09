<?php

namespace Tests\Feature;

use App\Models\ContactRequest;
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

        $inbox = $this->get('/_private-inbox/d7f4a9c2e81b6d03a5f790ce42b18e6f9a0c5d73b2e84f16');

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