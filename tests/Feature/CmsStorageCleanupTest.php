<?php

namespace Tests\Feature;

use App\Models\Facility;
use App\Models\Media;
use App\Models\PpidDocument;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CmsStorageCleanupTest extends TestCase
{
    use RefreshDatabase;

    public function test_facility_images_are_deleted_when_replaced_or_record_is_deleted(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('facilities/old.jpg', 'old');
        Storage::disk('public')->put('facilities/new.jpg', 'new');

        $facility = Facility::create([
            'category' => 'Layanan Terminal',
            'name' => 'Area Check-in',
            'image' => 'facilities/old.jpg',
            'details' => ['Area check-in.'],
            'order' => 1,
        ]);

        $facility->update(['image' => 'facilities/new.jpg']);
        Storage::disk('public')->assertMissing('facilities/old.jpg');

        $facility->delete();
        Storage::disk('public')->assertMissing('facilities/new.jpg');
    }

    public function test_ppid_documents_are_deleted_when_replaced_or_record_is_deleted(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('ppid-documents/old.pdf', 'old');
        Storage::disk('public')->put('ppid-documents/new.pdf', 'new');

        $document = PpidDocument::create([
            'title' => 'Dokumen PPID',
            'category' => 'informasi-berkala',
            'file_path' => 'ppid-documents/old.pdf',
            'is_active' => true,
            'published_at' => now(),
        ]);

        $document->update(['file_path' => 'ppid-documents/new.pdf']);
        Storage::disk('public')->assertMissing('ppid-documents/old.pdf');

        $document->delete();
        Storage::disk('public')->assertMissing('ppid-documents/new.pdf');
    }

    public function test_media_file_is_deleted_when_record_is_deleted(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('media/photo.jpg', 'photo');

        $media = Media::create([
            'disk' => 'public',
            'path' => 'media/photo.jpg',
            'filename' => 'photo.jpg',
            'mime_type' => 'image/jpeg',
        ]);

        $media->delete();

        Storage::disk('public')->assertMissing('media/photo.jpg');
    }

    public function test_airline_logos_are_deleted_when_replaced_or_record_is_deleted(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('airlines/old.png', 'old');
        Storage::disk('public')->put('airlines/new.png', 'new');

        $airline = \App\Models\Airline::create([
            'name' => 'Garuda Indonesia',
            'slug' => 'garuda-indonesia',
            'logo' => 'airlines/old.png',
            'is_active' => true,
        ]);

        $airline->update(['logo' => 'airlines/new.png']);
        Storage::disk('public')->assertMissing('airlines/old.png');

        $airline->delete();
        Storage::disk('public')->assertMissing('airlines/new.png');
    }

    public function test_airline_static_logo_is_preserved_when_record_is_deleted(): void
    {
        Storage::fake('public');

        $airline = \App\Models\Airline::create([
            'name' => 'Batik Air Test',
            'slug' => 'batik-air-test',
            'logo' => 'images/airlines/batik-air.png',
            'is_active' => true,
        ]);

        $airline->delete();
        $this->assertDatabaseMissing('airlines', ['id' => $airline->id]);
    }
}

