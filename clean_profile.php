<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$page = App\Models\Page::where('slug', 'profil-bandara-kalimarau')->first();
if ($page) {
    $content = $page->content;
    
    // Remove images with empty src
    $content = preg_replace('/<img[^>]*src=""[^>]*>/i', '', $content);
    
    // Remove empty h2
    $content = preg_replace('/<h2>\s*<\/h2>/i', '', $content);
    
    // Add some nice tailwind classes to all images
    // Wait, it's better to do this in CSS for all pages, but we can do it here as well
    // or just leave it to CSS. I will just clean up the broken tags.
    
    $page->content = $content;
    $page->save();
    echo "Cleaned up Profil Bandara Kalimarau page.\n";
}
