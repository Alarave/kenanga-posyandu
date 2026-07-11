<?php

use Illuminate\Support\Facades\Storage;

if (! function_exists('storage_url')) {
    /**
     * Resolve the public URL for an uploaded file.
     *
     * When FILESYSTEM_CLOUD=r2 (or any S3-compatible disk) is set,
     * this returns the R2 URL automatically. Otherwise it falls back
     * to the standard local /storage URL via asset().
     *
     * Usage in Blade: {{ storage_url($model->photo) }}
     *
     * @param  string|null  $path  Relative path stored in DB (e.g. 'galleries/foo.jpg')
     * @return string
     */
    function storage_url(?string $path): string
    {
        if (! $path) {
            return '';
        }

        $cloudDisk = config('filesystems.cloud', 'public');

        // For non-local disks (R2, S3 etc.) use Storage::disk()->url()
        // This returns the correct CDN/R2 URL
        if ($cloudDisk !== 'public' && $cloudDisk !== 'local') {
            return Storage::disk($cloudDisk)->url($path);
        }

        // Local development: use Laravel's standard asset('storage/...') pattern
        return asset('storage/' . $path);
    }
}
