<?php

namespace App\Support;

/**
 * Shrinks uploaded photos and converts them to WebP so the site stays fast
 * even when someone uploads a 10 MB camera photo. Falls back to the original file.
 */
class ImageOptimizer
{
    public static function optimize(string $absolutePath, int $maxWidth = 2000, int $quality = 82): string
    {
        if (! function_exists('imagewebp') || ! is_file($absolutePath)) {
            return $absolutePath;
        }

        $info = @getimagesize($absolutePath);
        if (! $info) {
            return $absolutePath;
        }

        $image = match ($info[2]) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($absolutePath),
            IMAGETYPE_PNG => @imagecreatefrompng($absolutePath),
            IMAGETYPE_WEBP => @imagecreatefromwebp($absolutePath),
            default => false,
        };

        if (! $image) {
            return $absolutePath;
        }

        if ($info[2] === IMAGETYPE_JPEG && function_exists('exif_read_data')) {
            $exif = @exif_read_data($absolutePath);
            $image = match ($exif['Orientation'] ?? 1) {
                3 => imagerotate($image, 180, 0),
                6 => imagerotate($image, -90, 0),
                8 => imagerotate($image, 90, 0),
                default => $image,
            };
        }

        if (imagesx($image) > $maxWidth) {
            $image = imagescale($image, $maxWidth, -1, IMG_BICUBIC);
        }

        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);

        $target = preg_replace('/\.[^.]+$/', '', $absolutePath).'.webp';
        $ok = imagewebp($image, $target, $quality);
        imagedestroy($image);

        if (! $ok) {
            return $absolutePath;
        }

        if ($target !== $absolutePath) {
            @unlink($absolutePath);
        }

        return $target;
    }
}
