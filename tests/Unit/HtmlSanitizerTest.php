<?php

namespace Tests\Unit;

use App\Support\HtmlSanitizer;
use PHPUnit\Framework\TestCase;

class HtmlSanitizerTest extends TestCase
{
    public function test_it_removes_scripts_event_handlers_and_javascript_urls(): void
    {
        $dirty = '<h2 onclick="alert(1)">Judul</h2><script>alert(1)</script><p><a href="javascript:alert(1)">Klik</a></p><img src="/storage/foo.jpg" onerror="alert(1)">';

        $clean = HtmlSanitizer::clean($dirty);

        $this->assertStringContainsString('<h2>Judul</h2>', $clean);
        $this->assertStringNotContainsString('<script', $clean);
        $this->assertStringNotContainsString('alert(1)', $clean);
        $this->assertStringNotContainsString('onclick', $clean);
        $this->assertStringNotContainsString('onerror', $clean);
        $this->assertStringNotContainsString('javascript:', $clean);
        $this->assertStringContainsString('<img src="/storage/foo.jpg">', $clean);
    }

    public function test_it_keeps_safe_editor_markup(): void
    {
        $dirty = '<p class="lead">Teks <strong>penting</strong></p><ul><li>Item</li></ul><table><tr><th>Kolom</th></tr><tr><td>Isi</td></tr></table>';

        $clean = HtmlSanitizer::clean($dirty);

        $this->assertStringContainsString('<p class="lead">Teks <strong>penting</strong></p>', $clean);
        $this->assertStringContainsString('<ul><li>Item</li></ul>', $clean);
        $this->assertStringContainsString('<table><tr><th>Kolom</th></tr><tr><td>Isi</td></tr></table>', $clean);
    }
}
