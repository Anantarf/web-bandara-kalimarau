<?php

namespace App\Console\Commands;

use App\Services\ImageOptimizer;
use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class OptimizeImagesCommand extends Command
{
    protected $signature = 'images:optimize 
                            {directory? : Subdirectory inside storage/app/public to optimize (default: all)}
                            {--max-width=1600 : Max width in pixels}
                            {--max-height=1200 : Max height in pixels}
                            {--quality=82 : Compression quality 1-100}';

    protected $description = 'Compress and resize images in storage/app/public';

    public function handle(): int
    {
        $subDir = $this->argument('directory');
        $rootPath = realpath(storage_path('app/public'));
        $targetPath = storage_path('app/public'.($subDir ? DIRECTORY_SEPARATOR.trim($subDir, '/\\') : ''));
        $basePath = realpath($targetPath);

        if (! $rootPath || ! $basePath || ! is_dir($basePath)) {
            $this->error("Directory does not exist: {$targetPath}");

            return self::FAILURE;
        }

        $normalizedRoot = rtrim($rootPath, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
        $normalizedBase = rtrim($basePath, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

        if ($normalizedBase !== $normalizedRoot && ! str_starts_with($normalizedBase, $normalizedRoot)) {
            $this->error('Directory must be inside storage/app/public.');

            return self::FAILURE;
        }

        $maxWidth = (int) $this->option('max-width');
        $maxHeight = (int) $this->option('max-height');
        $quality = (int) $this->option('quality');

        $this->info("Scanning images in {$basePath}...");
        $this->info("Target bounds: {$maxWidth}x{$maxHeight}, Quality: {$quality}%");

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($basePath, RecursiveDirectoryIterator::SKIP_DOTS)
        );

        $validExtensions = ['jpg', 'jpeg', 'png', 'webp'];
        $files = [];

        foreach ($iterator as $item) {
            if ($item->isFile()) {
                $ext = strtolower($item->getExtension());
                if (in_array($ext, $validExtensions, true)) {
                    $files[] = $item->getPathname();
                }
            }
        }

        $totalFiles = count($files);
        if ($totalFiles === 0) {
            $this->warn('No images found to optimize.');

            return self::SUCCESS;
        }

        $this->info("Found {$totalFiles} images. Optimizing...");

        $totalOrigBytes = 0;
        $totalOptBytes = 0;
        $optimizedCount = 0;

        $bar = $this->output->createProgressBar($totalFiles);
        $bar->start();

        foreach ($files as $filePath) {
            $origSize = filesize($filePath);
            $totalOrigBytes += $origSize;

            $res = ImageOptimizer::optimize($filePath, $maxWidth, $maxHeight, $quality);

            $newSize = filesize($filePath);
            $totalOptBytes += $newSize;

            if ($origSize > $newSize) {
                $optimizedCount++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $savedBytes = $totalOrigBytes - $totalOptBytes;
        $savedPercent = $totalOrigBytes > 0 ? round(($savedBytes / $totalOrigBytes) * 100, 1) : 0;

        $this->table(
            ['Metric', 'Value'],
            [
                ['Total Files Scanned', $totalFiles],
                ['Files Compressed', $optimizedCount],
                ['Size Before', round($totalOrigBytes / 1024 / 1024, 2).' MB'],
                ['Size After', round($totalOptBytes / 1024 / 1024, 2).' MB'],
                ['Total Saved', round($savedBytes / 1024 / 1024, 2).' MB ('.$savedPercent.'%)'],
            ]
        );

        $this->info('Image optimization completed successfully!');

        return self::SUCCESS;
    }
}
