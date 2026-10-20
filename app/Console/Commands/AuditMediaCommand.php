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
    protected $signature = 'media:audit
                            {--disk= : Storage disk to audit}
                            {--delete-orphans : Delete unreferenced managed files}
                            {--force : Confirm destructive orphan deletion}';

    protected $description = 'Report missing and unreferenced managed media files';

    public function handle(): int
    {
        if ($this->option('delete-orphans') && ! $this->option('force')) {
            $this->error('Orphan deletion requires the --force option. Run without --delete-orphans to preview the result.');

            return self::FAILURE;
        }

        $diskName = $this->option('disk') ?: MediaStorage::diskName();
        $disk = app('filesystem')->disk($diskName);
        $referencedPaths = $this->referencedPaths($diskName);
        $storedPaths = collect(config('media.managed_directories'))
            ->flatMap(fn (string $directory) => $disk->allFiles($directory))
            ->map(fn (string $path) => ltrim($path, '/'))
            ->unique()
            ->sort()
            ->values();

        $missingPaths = $referencedPaths->diff($storedPaths)->values();
        $orphanedPaths = $storedPaths->diff($referencedPaths)->values();

        $this->info("Media audit completed for disk [{$diskName}].");
        $this->table(['Metric', 'Count'], [
            ['Referenced paths', $referencedPaths->count()],
            ['Stored managed files', $storedPaths->count()],
            ['Missing referenced files', $missingPaths->count()],
            ['Unreferenced files', $orphanedPaths->count()],
        ]);

        $this->renderPaths('Missing referenced files', $missingPaths);
        $this->renderPaths('Unreferenced files', $orphanedPaths);

        if ($this->option('delete-orphans') && $orphanedPaths->isNotEmpty()) {
            $disk->delete($orphanedPaths->all());
            $this->info("Deleted {$orphanedPaths->count()} unreferenced file(s).");
        }

        Log::info('Media audit completed.', [
            'disk' => $diskName,
            'referenced' => $referencedPaths->count(),
            'stored' => $storedPaths->count(),
            'missing' => $missingPaths->count(),
            'orphaned' => $orphanedPaths->count(),
            'deleted_orphans' => $this->option('delete-orphans'),
        ]);

        return self::SUCCESS;
    }

    private function referencedPaths(string $diskName): Collection
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

    private function isManagedPath(string $path): bool
    {
        $normalizedPath = ltrim($path, '/');

        return collect(config('media.managed_directories'))
            ->contains(fn (string $directory) => str_starts_with($normalizedPath, trim($directory, '/').'/'));
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
