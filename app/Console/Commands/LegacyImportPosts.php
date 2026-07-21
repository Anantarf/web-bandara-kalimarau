<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\User;
use App\Services\LegacyContentCleaner;
use App\Services\LegacyMediaImporter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LegacyImportPosts extends Command
{
    protected $signature = 'legacy:import-posts';

    protected $description = 'Import WordPress post_type=post (publish/draft) from the legacy DB into posts';

    public function handle(LegacyMediaImporter $mediaImporter): int
    {
        $defaultAuthorId = User::where('email', 'admin@kalimarau.local')->value('id');

        $rows = DB::connection('legacy')->table('posts')
            ->where('post_type', 'post')
            ->whereIn('post_status', ['publish', 'draft'])
            ->orderBy('post_date')
            ->get();

        $thumbnailIds = DB::connection('legacy')->table('postmeta')
            ->whereIn('post_id', $rows->pluck('ID'))
            ->where('meta_key', '_thumbnail_id')
            ->pluck('meta_value', 'post_id');

        $created = 0;
        $updated = 0;

        DB::transaction(function () use ($rows, $thumbnailIds, $mediaImporter, $defaultAuthorId, &$created, &$updated) {
            foreach ($rows as $row) {
                $thumbnailId = $thumbnailIds[$row->ID] ?? null;

                $featuredImage = $mediaImporter->resolve($thumbnailId ? (int) $thumbnailId : null);

                $slug = $row->post_name ?: str($row->post_title)->slug();
                if (Post::where('slug', $slug)->where('legacy_id', '!=', $row->ID)->exists()) {
                    $slug .= '-'.$row->ID;
                }

                $attributes = [
                    'featured_image' => $featuredImage?->path,
                    'author_id' => $defaultAuthorId,
                    'title' => Str::limit(html_entity_decode($row->post_title, ENT_QUOTES), 250, ''),
                    'slug' => Str::limit($slug, 250, ''),
                    'excerpt' => $row->post_excerpt ?: null,
                    'content' => $mediaImporter->rewriteInlineImages(LegacyContentCleaner::clean($row->post_content)),
                    'status' => $row->post_status === 'publish' ? 'published' : 'draft',
                    'published_at' => $row->post_status === 'publish' ? $row->post_date : null,
                ];

                $post = Post::where('legacy_id', $row->ID)->first();

                if ($post) {
                    $post->update($attributes);
                    $updated++;
                } else {
                    Post::create(['legacy_id' => $row->ID, ...$attributes]);
                    $created++;
                }
            }
        });

        $this->info("Posts imported: {$created} created, {$updated} updated (of {$rows->count()} legacy rows).");

        if ($mediaImporter->missingImages) {
            $this->warn(count($mediaImporter->missingImages).' inline image(s) had no local file and were dropped:');
            foreach (array_unique($mediaImporter->missingImages) as $url) {
                $this->line("  - {$url}");
            }
        }

        return self::SUCCESS;
    }
}
