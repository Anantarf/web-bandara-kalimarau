<?php

namespace Tests\Unit;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicMediaUrlTest extends TestCase
{
    public function test_post_and_page_featured_images_use_the_configured_media_disk_url(): void
    {
        Storage::fake('public');

        $path = 'featured-images/cover.jpg';
        $expectedUrl = Storage::disk('public')->url($path);

        $this->assertSame($expectedUrl, (new Post(['featured_image' => $path]))->featured_image_url);
        $this->assertSame($expectedUrl, (new Page(['featured_image' => $path]))->featured_image_url);
    }
}
