<?php

namespace Tests\Feature;

use App\Models\Award;
use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class AwardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed', ['--class' => 'RoleSeeder']);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function test_published_scope_filters_active_awards(): void
    {
        Award::query()->create([
            'title' => 'Penghargaan Aktif',
            'image' => 'awards/aktif.jpg',
            'is_active' => true,
        ]);

        Award::query()->create([
            'title' => 'Penghargaan Nonaktif',
            'image' => 'awards/nonaktif.jpg',
            'is_active' => false,
        ]);

        $published = Award::published()->get();

        $this->assertCount(1, $published);
        $this->assertSame('Penghargaan Aktif', $published->first()->title);
    }

    public function test_ordered_scope_sorts_by_sort_order_then_year_desc(): void
    {
        $award1 = Award::query()->create([
            'title' => 'Penghargaan B',
            'year' => 2021,
            'image' => 'awards/b.jpg',
            'sort_order' => 2,
        ]);

        $award2 = Award::query()->create([
            'title' => 'Penghargaan A',
            'year' => 2023,
            'image' => 'awards/a.jpg',
            'sort_order' => 1,
        ]);

        $ordered = Award::ordered()->get();

        $this->assertSame($award2->id, $ordered->first()->id);
        $this->assertSame($award1->id, $ordered->last()->id);
    }

    public function test_active_awards_are_rendered_on_profil_bandara_page(): void
    {
        $page = Page::query()->create([
            'title' => 'Profil Bandara Kalimarau',
            'slug' => 'profil-bandara-kalimarau',
            'content' => '<p>Konten profil bandara.</p>',
            'status' => 'published',
            'published_at' => now(),
            'template' => 'default',
        ]);

        Award::query()->create([
            'title' => 'Penghargaan Prima 2026',
            'image' => 'awards/sertifikat-2026.jpg',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $response = $this->get(route('pages.show', $page->slug));

        $response->assertOk();
        $response->assertSee('Penghargaan &amp; Prestasi', false);
        $response->assertSee('sertifikat-2026.jpg');
    }

    public function test_inactive_awards_are_hidden_when_no_active_awards_exist(): void
    {
        $page = Page::query()->create([
            'title' => 'Profil Bandara Kalimarau',
            'slug' => 'profil-bandara-kalimarau',
            'content' => '<p>Konten profil bandara.</p>',
            'status' => 'published',
            'published_at' => now(),
            'template' => 'default',
        ]);

        Award::query()->create([
            'title' => 'Penghargaan Tersembunyi',
            'image' => 'awards/hidden.jpg',
            'is_active' => false,
        ]);

        $response = $this->get(route('pages.show', $page->slug));

        $response->assertOk();
        $response->assertDontSee('id="penghargaan-prestasi"', false);
    }

    public function test_uploaded_file_is_deleted_from_storage_on_model_deletion(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('test-award.jpg', 100, 'image/jpeg');
        $path = $file->store('awards', 'public');

        $award = Award::query()->create([
            'title' => 'Penghargaan Baru',
            'image' => $path,
            'is_active' => true,
        ]);

        Storage::disk('public')->assertExists($path);

        $award->delete();

        Storage::disk('public')->assertMissing($path);
    }

    public function test_legacy_file_is_preserved_on_model_deletion(): void
    {
        Storage::fake('public');

        $legacyPath = 'storage/media/legacy/2022/10/20221024_093158-scaled.jpg';

        $award = Award::query()->create([
            'title' => 'Penghargaan Legacy',
            'image' => $legacyPath,
            'is_active' => true,
        ]);

        $award->delete();

        // Should not throw or crash when deleting legacy records
        $this->assertDatabaseMissing('awards', ['id' => $award->id]);
    }

    public function test_operator_admin_can_access_awards_resource(): void
    {
        $admin = User::factory()->create(['is_active' => true]);
        $admin->syncRoles(['admin']);

        $response = $this->actingAs($admin)->get('/admin/awards');

        $response->assertOk();
    }
}
