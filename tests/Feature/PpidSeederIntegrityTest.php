<?php

namespace Tests\Feature;

use App\Http\Controllers\PageController;
use App\Models\Award;
use App\Models\ContactMessage;
use App\Models\Facility;
use App\Models\Page;
use App\Models\PpidDocument;
use App\Models\PublicServiceLink;
use Database\Seeders\AwardSeeder;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\FacilitySeeder;
use Database\Seeders\PageSeeder;
use Database\Seeders\PpidDocumentSeeder;
use Database\Seeders\PublicServiceLinkSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PpidSeederIntegrityTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_does_not_delete_contact_messages(): void
    {
        $message = ContactMessage::create([
            'name' => 'Warga Berau',
            'email' => 'warga@example.com',
            'phone' => '081234567890',
            'subject' => 'Pertanyaan Layanan',
            'message' => 'Isi pesan pengaduan warga penting.',
            'status' => 'unread',
        ]);

        $this->seed(PpidDocumentSeeder::class);

        $this->assertDatabaseHas('contact_messages', [
            'id' => $message->id,
            'email' => 'warga@example.com',
        ]);
    }

    public function test_database_seeder_does_not_delete_contact_messages_on_deploy(): void
    {
        $message = ContactMessage::create([
            'name' => 'Pengguna Bandara',
            'email' => 'pengguna@example.com',
            'phone' => '089876543210',
            'subject' => 'Saran Fasilitas',
            'message' => 'Saran penambahan kursi ruang tunggu.',
            'status' => 'read',
        ]);

        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseHas('contact_messages', [
            'id' => $message->id,
            'email' => 'pengguna@example.com',
        ]);
    }

    public function test_image_optimizer_command_rejects_paths_outside_public_storage(): void
    {
        $exitCode = Artisan::call('images:optimize', ['directory' => '..']);

        $this->assertSame(1, $exitCode);
        $this->assertStringContainsString('Directory must be inside storage/app/public.', Artisan::output());
    }

    public function test_seeder_preserves_admin_cms_edits_on_ppid_documents(): void
    {
        // 1. Initial seed
        $this->seed(PpidDocumentSeeder::class);

        // 2. Admin edits document via CMS
        $document = PpidDocument::where('title', 'Standar Pelayanan Publik UPBU Kelas I Kalimarau 2023')->firstOrFail();
        $document->update([
            'description' => 'Deskripsi yang sudah diperbarui oleh Admin CMS.',
            'is_active' => false,
            'sort_order' => 99,
        ]);

        // 3. Re-running seeder (as happens on deploy)
        $this->seed(PpidDocumentSeeder::class);

        // 4. Assert admin changes are preserved
        $document->refresh();
        $this->assertSame('Deskripsi yang sudah diperbarui oleh Admin CMS.', $document->description);
        $this->assertFalse($document->is_active);
        $this->assertSame(99, $document->sort_order);
    }

    public function test_seeder_preserves_admin_cms_edits_on_facilities(): void
    {
        Storage::fake('public');

        $this->seed(FacilitySeeder::class);

        $facility = Facility::where('name', 'Area Check-in')->firstOrFail();
        $facility->update([
            'category' => 'Informasi & Pengaduan',
            'image' => 'facilities/cms-uploaded-area-check-in.jpg',
            'details' => ['Detail fasilitas hasil edit admin CMS.'],
            'order' => 77,
        ]);

        $this->seed(FacilitySeeder::class);

        $facility->refresh();
        $this->assertSame('Informasi & Pengaduan', $facility->category);
        $this->assertSame('facilities/cms-uploaded-area-check-in.jpg', $facility->image);
        $this->assertSame(['Detail fasilitas hasil edit admin CMS.'], $facility->details);
        $this->assertSame(77, $facility->order);
    }

    public function test_seeder_preserves_admin_cms_edits_on_pages(): void
    {
        $this->seed(PageSeeder::class);

        $page = Page::where('slug', 'fasilitas-bandara')->firstOrFail();
        $page->update([
            'title' => 'Fasilitas Bandara Hasil Edit CMS',
            'excerpt' => 'Ringkasan hasil edit admin CMS.',
            'content' => '<p>Konten fasilitas hasil edit admin CMS.</p>',
            'template' => 'custom-cms',
            'status' => 'draft',
            'published_at' => null,
        ]);

        $this->seed(PageSeeder::class);

        $page->refresh();
        $this->assertSame('Fasilitas Bandara Hasil Edit CMS', $page->title);
        $this->assertSame('Ringkasan hasil edit admin CMS.', $page->excerpt);
        $this->assertStringContainsString('Konten fasilitas hasil edit admin CMS.', $page->content);
        $this->assertSame('custom-cms', $page->template);
        $this->assertSame('draft', $page->status);
        $this->assertNull($page->published_at);
    }

    public function test_seeder_preserves_admin_cms_edits_on_public_service_links(): void
    {
        $this->seed(PublicServiceLinkSeeder::class);

        $link = PublicServiceLink::where('slug', 'sp4n-lapor')->firstOrFail();
        $link->update([
            'title' => 'SP4N LAPOR Edit CMS',
            'description' => 'Deskripsi link hasil edit admin CMS.',
            'url' => 'https://example.test/lapor',
            'category' => 'Pengaduan',
            'is_external' => false,
            'is_active' => false,
            'icon' => 'heroicon-o-link',
            'sort_order' => 77,
        ]);

        $this->seed(PublicServiceLinkSeeder::class);

        $link->refresh();
        $this->assertSame('SP4N LAPOR Edit CMS', $link->title);
        $this->assertSame('Deskripsi link hasil edit admin CMS.', $link->description);
        $this->assertSame('https://example.test/lapor', $link->url);
        $this->assertFalse($link->is_external);
        $this->assertFalse($link->is_active);
        $this->assertSame('heroicon-o-link', $link->icon);
        $this->assertSame(77, $link->sort_order);
    }

    public function test_seeder_preserves_admin_cms_edits_on_awards(): void
    {
        $this->seed(AwardSeeder::class);

        $award = Award::where('image', 'media/legacy/2022/10/20221024_093158-scaled.jpg')->firstOrFail();
        $award->update([
            'title' => 'Penghargaan Hasil Edit CMS',
            'issuer' => 'Admin CMS',
            'year' => 2026,
            'description' => 'Deskripsi penghargaan hasil edit admin CMS.',
            'is_active' => false,
            'sort_order' => 88,
        ]);

        $this->seed(AwardSeeder::class);

        $award->refresh();
        $this->assertSame('Penghargaan Hasil Edit CMS', $award->title);
        $this->assertSame('Admin CMS', $award->issuer);
        $this->assertSame(2026, $award->year);
        $this->assertSame('Deskripsi penghargaan hasil edit admin CMS.', $award->description);
        $this->assertFalse($award->is_active);
        $this->assertSame(88, $award->sort_order);
    }

    public function test_all_ppid_routes_from_seeder_load_successfully(): void
    {
        $this->seed(PageSeeder::class);

        // Root PPID
        $this->get(route('ppid.show'))->assertOk();

        // All 14 PPID sub routes
        foreach (PageController::PPID_MAP as $sub => $slug) {
            $response = $this->get(route('ppid.show', $sub));

            if (in_array($sub, ['visi-misi', 'tugas-dan-fungsi'], true)) {
                $response->assertStatus(301);
            } else {
                $response->assertOk();
            }
        }
    }

    public function test_ppid_regulasi_page_does_not_have_duplicate_title(): void
    {
        $this->seed(PageSeeder::class);
        $this->seed(PpidDocumentSeeder::class);

        $response = $this->get(route('ppid.show', 'regulasi'));
        $response->assertOk();

        // The content area should not contain a duplicate <h2>Regulasi</h2> or <h1>Regulasi</h1> right in main body
        $response->assertDontSee('<h2 id="regulasi">Regulasi</h2>', false);
        $response->assertDontSee('<h2>Regulasi</h2>', false);
        $response->assertSee('Dokumen Regulasi');
        $response->assertSee('Undang-Undang Nomor 14 Tahun 2008');
        $response->assertSee('Unduh');
    }

    public function test_ppid_document_with_external_url_renders_properly(): void
    {
        $this->seed(PageSeeder::class);

        PpidDocument::create([
            'title' => 'Regulasi Eksternal Google Drive Test',
            'category' => 'regulasi',
            'external_url' => 'https://drive.google.com/file/d/test-regulasi-drive/view',
            'is_active' => true,
            'published_at' => now(),
            'sort_order' => 1,
        ]);

        $response = $this->get(route('ppid.show', 'regulasi'));
        $response->assertOk();
        $response->assertSee('Regulasi Eksternal Google Drive Test');
        $response->assertSee('https://drive.google.com/file/d/test-regulasi-drive/view');
    }
}
