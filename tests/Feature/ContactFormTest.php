<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'subject' => 'Pertanyaan jadwal penerbangan',
            'message' => 'Mohon info jadwal penerbangan ke Balikpapan minggu depan.',
        ], $overrides);
    }

    public function test_valid_submission_is_stored_and_redirects_with_success_message(): void
    {
        $payload = $this->validPayload();

        $response = $this->post(route('contact.store'), $payload);

        $response->assertRedirect(route('contact.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'name' => $payload['name'],
            'email' => $payload['email'],
            'phone' => $payload['phone'],
            'subject' => $payload['subject'],
            'message' => $payload['message'],
        ]);
    }

    public function test_missing_required_fields_are_rejected_and_nothing_is_stored(): void
    {
        $response = $this->post(route('contact.store'), []);

        $response->assertSessionHasErrors(['name', 'email', 'phone', 'subject', 'message']);
        $this->assertSame(0, ContactMessage::count());
    }

    public function test_invalid_email_is_rejected(): void
    {
        $response = $this->post(route('contact.store'), $this->validPayload(['email' => 'not-an-email']));

        $response->assertSessionHasErrors('email');
        $this->assertSame(0, ContactMessage::count());
    }

    public function test_submission_is_rate_limited_after_three_requests_per_minute(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $this->post(route('contact.store'), $this->validPayload())->assertRedirect(route('contact.index'));
        }

        $this->post(route('contact.store'), $this->validPayload())->assertStatus(429);

        $this->assertSame(3, ContactMessage::count());
    }
}
