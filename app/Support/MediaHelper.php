<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use KaziOmar\SmartUpload\Facades\Upload;

class MediaHelper
{
    /**
     * Resolve an upload URL using SmartUpload, falling back to the original
     * file if the requested variant does not exist on disk.
     */
    public static function url(?string $path, ?string $variant = null, ?string $fallback = null): ?string
    {
        if (empty($path)) {
            return $fallback;
        }

        if ($variant) {
            $variantPath = Upload::variantPath($path, $variant);
            if ($variantPath !== $path && Storage::disk('uploads')->exists($variantPath)) {
                return upload_url($path, fallback: $fallback, variant: $variant);
            }
        }

        return upload_url($path, fallback: $fallback);
    }
}
