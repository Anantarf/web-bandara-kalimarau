<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Resolves a WordPress attachment (by legacy post ID) into a Laravel Media row,
 * copying only the physical files that are actually referenced as featured
 * images — per docs/DATA MIGRATION PLAN.md, not the full 1.7GB uploads folder.
 */
class LegacyMediaImporter
{
    /** @var array<int, string> Old-domain image URLs that had no local file to copy. */
    public array $missingImages = [];

    public function resolve(?int $legacyAttachmentId): ?Media
    {
        if (! $legacyAttachmentId) {
            return null;
        }

        if ($existing = Media::where('legacy_id', $legacyAttachmentId)->first()) {
            return $existing;
        }

        $attachment = DB::connection('legacy')->table('posts')
            ->where('ID', $legacyAttachmentId)
            ->where('post_type', 'attachment')
            ->first();

        if (! $attachment) {
            return null;
        }

        $relativePath = DB::connection('legacy')->table('postmeta')
            ->where('post_id', $legacyAttachmentId)
            ->where('meta_key', '_wp_attached_file')
            ->value('meta_value');

        if (! $relativePath) {
            return null;
        }

        $uploadsRoot = rtrim((string) env('LEGACY_UPLOADS_PATH'), '\\/');
        $sourcePath = $uploadsRoot.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $relativePath);

        if (! is_file($sourcePath)) {
            return null;
        }

        $destinationPath = 'media/legacy/'.$relativePath;
        Storage::disk('public')->put($destinationPath, file_get_contents($sourcePath));

        $imageSize = str_starts_with((string) $attachment->post_mime_type, 'image/')
            ? @getimagesize($sourcePath)
            : false;

        return Media::create([
            'legacy_id' => $legacyAttachmentId,
            'disk' => 'public',
            'path' => $destinationPath,
            'filename' => basename($relativePath),
            'mime_type' => $attachment->post_mime_type ?: 'application/octet-stream',
            'size' => filesize($sourcePath),
            'width' => $imageSize[0] ?? null,
            'height' => $imageSize[1] ?? null,
            'alt_text' => DB::connection('legacy')->table('postmeta')
                ->where('post_id', $legacyAttachmentId)
                ->where('meta_key', '_wp_attachment_image_alt')
                ->value('meta_value'),
        ]);
    }

    /**
     * Post/page content can embed <img> tags pointing straight at the old
     * kalimarau-airport.com domain instead of going through featured_image_id.
     * Copy those files locally too and rewrite the URLs, per docs/DATA
     * MIGRATION PLAN.md ("pastikan gambar memakai path media Laravel").
     */
    public function rewriteInlineImages(string $html): string
    {
        $uploadsRoot = rtrim((string) env('LEGACY_UPLOADS_PATH'), '\\/');

        // Responsive variants we don't localize; keep only the single src used.
        $html = preg_replace('/\s+(srcset|sizes)="[^"]*"/i', '', $html);

        preg_match_all(
            '#(https?:)?//kalimarau-airport\.com/wp-content/uploads/([^\s"\'<>]+)#i',
            $html,
            $matches
        );

        foreach (array_unique($matches[0]) as $index => $matchedUrl) {
            $relativePath = ltrim($matches[2][$index], '/');
            $sourcePath = $uploadsRoot.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $relativePath);

            if (! is_file($sourcePath)) {
                // File isn't in the local backup (whole months are missing, not just images —
                // this also catches PDFs embedded via <iframe>). Blank the dead hotlink out
                // rather than leave a reference to the old domain; asset needs re-sourcing.
                $html = str_replace($matchedUrl, '', $html);
                $this->missingImages[] = $matchedUrl;

                continue;
            }

            $destinationPath = 'media/legacy/'.$relativePath;

            if (! Storage::disk('public')->exists($destinationPath)) {
                Storage::disk('public')->put($destinationPath, file_get_contents($sourcePath));
            }

            $html = str_replace($matchedUrl, Storage::disk('public')->url($destinationPath), $html);
        }

        return $html;
    }
}
