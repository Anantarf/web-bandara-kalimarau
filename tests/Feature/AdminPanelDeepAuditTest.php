<?php

namespace Tests\Feature;

use App\Models\AirportStat;
use App\Models\ContactMessage;
use App\Models\FlightSchedule;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class AdminPanelDeepAuditTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed', ['--class' => 'RoleSeeder']);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function test_create_and_edit_pages_for_every_resource(): void
    {
        $admin = User::factory()->create(['is_active' => true]);
        $admin->syncRoles(['super_admin']);
        $this->actingAs($admin);

        $post = Post::create(['title' => 'Test Post', 'slug' => 'test-post', 'content' => 'x', 'status' => 'draft', 'author_id' => $admin->id]);
        $flight = FlightSchedule::create(['airline' => 'Test Air', 'route_from' => 'A', 'route_to' => 'B', 'type' => 'keberangkatan', 'is_active' => true, 'days' => ['senin']]);
        $contact = ContactMessage::create(['name' => 'Test', 'email' => 'test@test.com', 'phone' => '123', 'category' => 'informasi', 'message' => 'x', 'status' => 'new']);
        $stat = AirportStat::create(['period_name' => 'Test', 'period_date' => now(), 'passenger_count' => 1, 'flight_count' => 1, 'cargo_count' => 1, 'is_active' => true]);

        $pages = [
            'admin' => 200,
            'admin/posts' => 200,
            'admin/posts/create' => 200,
            "admin/posts/{$post->id}/edit" => 200,
            'admin/flight-schedules' => 200,
            'admin/flight-schedules/create' => 200,
            "admin/flight-schedules/{$flight->id}/edit" => 200,
            'admin/contact-messages' => 200,
            "admin/contact-messages/{$contact->id}/edit" => 200,
            'admin/airport-stats' => 200,
            'admin/users' => 200,
            'admin/audit-logs' => 200,
        ];

        $failures = [];
        foreach ($pages as $path => $expected) {
            $response = $this->get('/'.$path);
            if ($response->status() !== $expected) {
                $failures[] = "{$path} => got {$response->status()}, expected {$expected}. ".($response->exception?->getMessage() ?? '');
            }
        }

        $this->assertEmpty($failures, implode("\n", $failures));
    }
}
