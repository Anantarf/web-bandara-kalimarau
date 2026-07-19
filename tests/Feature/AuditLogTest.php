<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\ContactMessage;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuditLogTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_admin_changes_are_recorded_without_sensitive_values(): void
    {
        $admin = User::factory()->create();
        $this->actingAs($admin);

        $post = Post::create([
            'title' => 'Berita Awal',
            'slug' => 'berita-awal',
            'status' => 'draft',
        ]);

        $post->update(['title' => 'Berita Diperbarui']);

        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $admin->id,
            'event' => 'created',
            'auditable_type' => Post::class,
            'auditable_id' => $post->id,
        ]);

        $updateLog = AuditLog::query()->where('event', 'updated')->sole();

        $this->assertSame('Berita Awal', $updateLog->old_values['title']);
        $this->assertSame('Berita Diperbarui', $updateLog->new_values['title']);
        $this->assertArrayNotHasKey('password', $updateLog->old_values);
        $this->assertArrayNotHasKey('password', $updateLog->new_values);
    }

    public function test_public_contact_submission_is_not_recorded_as_an_admin_audit_event(): void
    {
        ContactMessage::create([
            'name' => 'Pengunjung',
            'email' => 'pengunjung@example.test',
            'phone' => '08123456789',
            'subject' => 'Pertanyaan',
            'message' => 'Pesan dari formulir publik.',
        ]);

        $this->assertDatabaseCount('audit_logs', 0);
    }
}
