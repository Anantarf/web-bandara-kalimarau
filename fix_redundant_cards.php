<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$page = App\Models\Page::where('slug', 'profil-bandara-kalimarau')->first();

$content = $page->content;

// The first Misi card ends at line 98: </div>\n</div>
// Let's find the string and remove the redundant ones.
// We can use a regex or just strpos.

$firstMisiCardEnd = '</div>
    </div>
</div>';

$pos1 = strpos($content, $firstMisiCardEnd);

if ($pos1 !== false) {
    $endOfFirst = $pos1 + strlen($firstMisiCardEnd);
    $startOfKodeEtik = strpos($content, '<h2>Kode Etik Pegawai</h2>', $endOfFirst);
    
    if ($startOfKodeEtik !== false) {
        $cleanContent = substr($content, 0, $endOfFirst) . "\n\n" . substr($content, $startOfKodeEtik);
        $page->content = $cleanContent;
        $page->save();
        echo "Removed redundant Misi cards.\n";
    } else {
        echo "Kode Etik not found.\n";
    }
} else {
    echo "First Misi card end not found.\n";
}
