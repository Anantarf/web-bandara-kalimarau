<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class ImageOptimizer
{
    /**
     * Optimize an image file in-place using PHP GD.
     *
     * @param string $filePath Full absolute filesystem path
     * @param int $maxWidth Max width in pixels (default: 1600)
     * @param int $maxHeight Max height in pixels (default: 1200)
     * @param int $quality JPEG/WebP quality percentage 1-100 (default: 82)
     * @return array{success: bool, original_size: int, optimized_size: int, saved_bytes: int, percent: float}
     */
    public static function optimize(
        string $filePath,
        int $maxWidth = 1600,
        int $maxHeight = 1200,
        int $quality = 82
    ): array {
        $result = [
            'success' => false,
            'original_size' => 0,
            'optimized_size' => 0,
            'saved_bytes' => 0,
            'percent' => 0.0,
        ];

        if (! file_exists($filePath) || ! is_file($filePath)) {
            return $result;
        }

        $origSize = filesize($filePath);
        $result['original_size'] = $origSize;
        $result['optimized_size'] = $origSize;

        if ($origSize === 0) {
            return $result;
        }

        $imageInfo = @getimagesize($filePath);
        if (! $imageInfo) {
            return $result;
        }

        $width = $imageInfo[0];
        $height = $imageInfo[1];
        $mime = $imageInfo['mime'];

        // If file is already smaller than 200KB and within dimensions, skip recompression
        if ($origSize <= 200 * 1024 && $width <= $maxWidth && $height <= $maxHeight) {
            $result['success'] = true;
            return $result;
        }

        $srcImage = null;
        switch ($mime) {
            case 'image/jpeg':
                $srcImage = @imagecreatefromjpeg($filePath);
                break;
            case 'image/png':
                $srcImage = @imagecreatefrompng($filePath);
                break;
            case 'image/webp':
                if (function_exists('imagecreatefromwebp')) {
                    $srcImage = @imagecreatefromwebp($filePath);
                }
                break;
            default:
                return $result;
        }

        if (! $srcImage) {
            return $result;
        }

        // Handle JPEG EXIF orientation
        if ($mime === 'image/jpeg' && function_exists('exif_read_data')) {
            $exif = @exif_read_data($filePath);
            if (! empty($exif['Orientation'])) {
                switch ($exif['Orientation']) {
                    case 3:
                        $srcImage = imagerotate($srcImage, 180, 0);
                        break;
                    case 6:
                        $srcImage = imagerotate($srcImage, -90, 0);
                        $width = imagesx($srcImage);
                        $height = imagesy($srcImage);
                        break;
                    case 8:
                        $srcImage = imagerotate($srcImage, 90, 0);
                        $width = imagesx($srcImage);
                        $height = imagesy($srcImage);
                        break;
                }
            }
        }

        // Calculate proportional bounding dimensions
        $scale = min($maxWidth / max($width, 1), $maxHeight / max($height, 1), 1.0);
        $newWidth = (int) round($width * $scale);
        $newHeight = (int) round($height * $scale);

        $dstImage = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency for PNG and WebP
        if ($mime === 'image/png' || $mime === 'image/webp') {
            imagealphablending($dstImage, false);
            imagesavealpha($dstImage, true);
            $transparent = imagecolorallocatealpha($dstImage, 255, 255, 255, 127);
            imagefilledrectangle($dstImage, 0, 0, $newWidth, $newHeight, $transparent);
        }

        imagecopyresampled($dstImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        $tmpFile = $filePath . '.opt_tmp_' . uniqid();

        $saved = false;
        switch ($mime) {
            case 'image/jpeg':
                $saved = imagejpeg($dstImage, $tmpFile, $quality);
                break;
            case 'image/png':
                $saved = imagepng($dstImage, $tmpFile, 8);
                break;
            case 'image/webp':
                $saved = imagewebp($dstImage, $tmpFile, $quality);
                break;
        }

        imagedestroy($srcImage);
        imagedestroy($dstImage);

        if (! $saved || ! file_exists($tmpFile)) {
            if (file_exists($tmpFile)) {
                @unlink($tmpFile);
            }
            return $result;
        }

        $newSize = filesize($tmpFile);

        // Only overwrite if the new file is smaller, otherwise discard
        if ($newSize < $origSize) {
            @unlink($filePath);
            rename($tmpFile, $filePath);
            $result['success'] = true;
            $result['optimized_size'] = $newSize;
            $result['saved_bytes'] = $origSize - $newSize;
            $result['percent'] = round((1 - ($newSize / $origSize)) * 100, 1);
        } else {
            @unlink($tmpFile);
            $result['success'] = true;
        }

        return $result;
    }
}
