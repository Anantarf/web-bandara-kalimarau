<?php

namespace Tests\Feature;

use App\Models\AirportStat;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\FlightSchedule;
use App\Models\Media;
use App\Models\Page;
use App\Models\Post;
use App\Models\PublicServiceLink;
use App\Models\Redirect;
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

        $category = Category::create(['name' => 'Test Category', 'slug' => 'test-category', 'sort_order' => 0]);
        $post = Post::create(['title' => 'Test Post', 'slug' => 'test-post', 'content' => 'x', 'status' => 'draft', 'category_id' => $category->id, 'author_id' => $admin->id]);
        $page = Page::create(['title' => 'Test Page', 'slug' => 'test-page-audit', 'content' => 'x', 'status' => 'draft']);
        $flight = FlightSchedule::create(['airline' => 'Test Air', 'route_from' => 'A', 'route_to' => 'B', 'type' => 'keberangkatan', 'is_active' => true, 'days' => ['senin']]);
        $contact = ContactMessage::create(['name' => 'Test', 'email' => 'test@test.com', 'phone' => '123', 'category' => 'informasi', 'message' => 'x', 'status' => 'new']);
        $media = Media::create(['disk' => 'public', 'path' => 'media/test.jpg', 'filename' => 'test.jpg', 'mime_type' => 'image/jpeg', 'size' => 100]);
        $link = PublicServiceLink::create(['title' => 'Test Link', 'slug' => 'test-link', 'url' => 'https://example.com', 'category' => 'test', 'is_active' => true, 'sort_order' => 0]);
        $redirect = Redirect::create(['old_path' => '/test-old', 'new_path' => '/test-new', 'status_code' => 301, 'is_active' => true]);
        $stat = AirportStat::create(['period_name' => 'Test', 'period_date' => now(), 'passenger_count' => 1, 'flight_count' => 1, 'cargo_count' => 1, 'is_active' => true]);
        $user = User::factory()->create();

        $pages = [
            'admin' => 200,
            'admin/posts' => 200,
            'admin/posts/create' => 200,
            "admin/posts/{$post->id}/edit" => 200,
            'admin/pages' => 200,
            'admin/pages/create' => 200,
            "admin/pages/{$page->id}/edit" => 200,
            'admin/categories' => 200,
            'admin/categories/create' => 200,
            "admin/categories/{$category->id}/edit" => 200,
            'admin/flight-schedules' => 200,
            'admin/flight-schedules/create' => 200,
            "admin/flight-schedules/{$flight->id}/edit" => 200,
            'admin/contact-messages' => 200,
            "admin/contact-messages/{$contact->id}/edit" => 200,
            'admin/media' => 200,
            'admin/media/create' => 200,
            "admin/media/{$media->id}/edit" => 200,
            'admin/public-service-links' => 200,
            'admin/public-service-links/create' => 200,
            "admin/public-service-links/{$link->id}/edit" => 200,
            'admin/redirects' => 200,
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
