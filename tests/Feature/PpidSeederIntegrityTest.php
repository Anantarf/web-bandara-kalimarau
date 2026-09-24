<?php

namespace Tests\Feature;

use App\Http\Controllers\PageController;
use App\Models\ContactMessage;
use App\Models\Facility;
use App\Models\PpidDocument;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\FacilitySeeder;
use Database\Seeders\PageSeeder;
use Database\Seeders\PpidDocumentSeeder;
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
