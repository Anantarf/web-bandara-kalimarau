<?php

namespace App\Services;

/**
 * Strips WordPress/Elementor/ElementsKit cruft from legacy post_content so it's
 * safe to store and render. This is a best-effort automated pass, not a full
 * rebuild — pages built with Elementor accordions/widgets still need the manual
 * editorial review called for in docs/DATA MIGRATION PLAN.md.
 */
class LegacyContentCleaner
{
    public static function clean(?string $html): string
    {
        if (blank($html)) {
            return '';
        }

        $html = str_replace(['\r\n', '\n', '\t'], ["\n", "\n", ' '], $html);

        // Elementor inline <style> blocks (widget CSS dumped straight into post_content).
        $html = preg_replace('/<style\b[^>]*>.*?<\/style>/is', '', $html);

        // Gutenberg block comments: <!-- wp:paragraph --> ... <!-- /wp:paragraph -->
        $html = preg_replace('/<!--\s*\/?wp:[^>]*-->/i', '', $html);

        // Elementor/ElementsKit accordion toggle links -> keep the visible label only.
        $html = preg_replace('/<a[^>]*href="#collapse-[^"]*"[^>]*>(.*?)<\/a>/is', '$1', $html);

        // Whole site header/nav/search chrome that leaked into post_content on some
        // PPID pages (Elementor header template duplicated into the page body).
        $html = preg_replace('/<nav[^>]*data-toggle-icon[^>]*>.*?<\/nav>/is', '', $html);
        $html = preg_replace('/<a[^>]*href="#ekit_modal-popup-[^"]*"[^>]*>.*?<\/a>/is', '', $html);
        $html = preg_replace('/<form[^>]*role="search"[^>]*>.*?<\/form>/is', '', $html);

        // Any remaining HTML comments (widget markers, "Normal Icon" placeholders, etc).
        $html = preg_replace('/<!--.*?-->/s', '', $html);

        // Legacy shortcodes: [smartslider3 ...], [hfe_template ...], [table ...].
        $html = preg_replace('/\[[a-z0-9_\-]+[^\]]*\]/i', '', $html);

        // Strip data-ekit-*/aria-* attributes left behind on surviving tags.
        $html = preg_replace('/\s(data-ekit-[a-z-]+|aria-[a-z-]+|data-target)="[^"]*"/i', '', $html);

        // <img> tags whose src never resolved (lazy-load placeholders that were never
        // hydrated in the static HTML dump) — an empty src just renders a broken-image icon.
        $html = preg_replace('/<img\b[^>]*\ssrc=(["\'])\1[^>]*\/?>/i', '', $html);

        // Standalone "Menu"/"Memuat…" lines — leftover nav-widget labels/loading text with
        // no surrounding markup, common on PPID pages built from Elementor header templates.
        $html = preg_replace('/^\s*(Menu|Memuat…)\s*$/mi', '', $html);

        // Old domain used for internal links -> make relative (leave /wp-content/uploads/
        // links alone; LegacyMediaImporter::rewriteInlineImages handles those separately).
        $html = preg_replace('#https?://(?:www\.)?kalimarau-airport\.com(?!/wp-content/uploads)#i', '', $html);

        // Empty paragraphs and collapsed whitespace.
        $html = preg_replace('/<p>(&nbsp;|\s)*<\/p>/i', '', $html);
        $html = preg_replace('/\n{3,}/', "\n\n", $html);
        $html = preg_replace('/[ \t]{2,}/', ' ', $html);

        return trim($html);
    }
}
