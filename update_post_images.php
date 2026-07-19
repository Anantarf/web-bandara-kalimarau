<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$posts = App\Models\Post::latest()->take(3)->get();
$images = [
    'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=600&auto=format&fit=crop', // Survey/document
    'https://images.unsplash.com/photo-1565552643983-6623661be4bd?q=80&w=600&auto=format&fit=crop', // Airport/people
    'https://images.unsplash.com/photo-1515169067868-5387ec356754?q=80&w=600&auto=format&fit=crop', // Meeting room
];

foreach($posts as $i => $post) {
    if (isset($images[$i])) {
        $post->featured_image = $images[$i];
        $post->save();
        echo "Updated post: " . $post->title . "\n";
    }
}
