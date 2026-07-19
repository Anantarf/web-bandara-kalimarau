<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$page = App\Models\Page::where('slug', 'profil-bandara-kalimarau')->first();
file_put_contents('dump.html', $page->content);
