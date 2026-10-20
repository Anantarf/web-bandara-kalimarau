<?php

namespace App\Jobs;

use App\Services\ImageOptimizer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class OptimizeImage implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    public array $backoff = [60, 300];

    public function __construct(
        public readonly string $disk,
        public readonly string $path,
    ) {
        $this->onQueue('media');
    }

    public function handle(): void
    {
        if (! in_array(strtolower(pathinfo($this->path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp'], true)) {
            return;
        }

        if (config("filesystems.disks.{$this->disk}.driver") !== 'local') {
            Log::warning('Image optimization skipped because the media disk is not local.', [
                'disk' => $this->disk,
                'path' => $this->path,
            ]);

            return;
        }

        try {
            $filePath = Storage::disk($this->disk)->path($this->path);

            if (! is_file($filePath)) {
                Log::notice('Image optimization skipped because the file no longer exists.', [
                    'disk' => $this->disk,
                    'path' => $this->path,
                ]);

                return;
            }

            ImageOptimizer::optimize($filePath);
        } catch (Throwable $exception) {
            Log::error('Image optimization failed.', [
                'disk' => $this->disk,
                'path' => $this->path,
                'exception' => $exception,
            ]);

            throw $exception;
        }
    }
}
