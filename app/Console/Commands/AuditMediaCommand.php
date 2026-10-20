<?php

namespace App\Console\Commands;

use App\Models\Airline;
use App\Models\Award;
use App\Models\Facility;
use App\Models\Media;
use App\Models\Page;
use App\Models\Post;
use App\Models\PpidDocument;
use App\Models\SurveyReport;
use App\Support\MediaStorage;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class AuditMediaCommand extends Command
{
    protected $signature = 'media:audit {--disk= : Storage disk to audit}';

    protected $description = 'Report missing, protected, and safe-to-review managed media files';

    public function handle(): int
    {
        $diskName = $this->option('disk') ?: MediaStorage::diskName();
        $disk = app('filesystem')->disk($diskName);
        $storedPaths = collect(config('media.managed_directories'))
            ->flatMap(fn (string $directory) => $disk->allFiles($directory))
            ->map(fn (string $path) => ltrim($path, '/'))
            ->unique()
            ->sort()
            ->values();
        $inlineContentPaths = $this->inlineContentPaths($storedPaths);
        $referencedPaths = $this->databaseReferencedPaths($diskName)
            ->merge($inlineContentPaths)
            ->unique()
            ->sort()
            ->values();
        $missingPaths = $referencedPaths->diff($storedPaths)->values();
        $protectedPaths = $storedPaths->filter($this->isProtectedPath(...))->values();
        $reviewPaths = $storedPaths->diff($referencedPaths)->diff($protectedPaths)->values();

        $this->info("Media audit completed for disk [{$diskName}].");
        $this->table(['Metric', 'Count'], [
            ['Referenced paths', $referencedPaths->count()],
            ['Inline content references', $inlineContentPaths->count()],
            ['Stored managed files', $storedPaths->count()],
            ['Missing referenced files', $missingPaths->count()],
            ['Protected files', $protectedPaths->count()],
            ['Safe review files', $reviewPaths->count()],
        ]);

        $this->renderPaths('Missing referenced files', $missingPaths);
        $this->renderPaths('Protected files', $protectedPaths);
        $this->renderPaths('Safe review files', $reviewPaths);

        Log::info('Media audit completed.', [
            'disk' => $diskName,
            'referenced' => $referencedPaths->count(),
            'inline_references' => $inlineContentPaths->count(),
            'stored' => $storedPaths->count(),
            'missing' => $missingPaths->count(),
            'protected' => $protectedPaths->count(),
            'safe_to_review' => $reviewPaths->count(),
        ]);

        return self::SUCCESS;
    }

    private function databaseReferencedPaths(string $diskName): Collection
    {
        return collect([
            Post::query()->pluck('featured_image'),
            Page::query()->pluck('featured_image'),
            Facility::query()->pluck('image'),
            Airline::query()->pluck('logo'),
            Award::query()->pluck('image'),
            PpidDocument::query()->pluck('file_path'),
            SurveyReport::query()->pluck('file_path'),
            SurveyReport::query()->pluck('cover_image'),
            Media::query()->where('disk', $diskName)->pluck('path'),
        ])
            ->flatten()
            ->filter(fn (?string $path) => filled($path) && $this->isManagedPath($path))
            ->map(fn (string $path) => ltrim($path, '/'))
            ->unique()
            ->sort()
            ->values();
    }

    private function inlineContentPaths(Collection $storedPaths): Collection
    {
        $content = Post::query()->whereNotNull('content')->pluck('content')
            ->merge(Page::query()->whereNotNull('content')->pluck('content'))
            ->map(fn (string $html) => html_entity_decode($html, ENT_QUOTES | ENT_HTML5));

        return $storedPaths
            ->filter(fn (string $path) => $content->contains(fn (string $html) => str_contains($html, $path)))
            ->values();
    }

    private function isManagedPath(string $path): bool
    {
        $normalizedPath = ltrim($path, '/');

        return collect(config('media.managed_directories'))
            ->contains(fn (string $directory) => str_starts_with($normalizedPath, trim($directory, '/').'/'));
    }

    private function isProtectedPath(string $path): bool
    {
        return str_starts_with($path, 'media/legacy/');
    }

    private function renderPaths(string $title, Collection $paths): void
    {
        if ($paths->isEmpty()) {
            return;
        }

        $this->newLine();
        $this->warn($title.':');
        $this->table(['Path'], $paths->map(fn (string $path) => [$path])->all());
    }
}
