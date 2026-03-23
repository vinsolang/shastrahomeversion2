<?php

declare(strict_types=1);

namespace App\Support;

final class VersionedAsset
{
    public static function url(string $path): string
    {
        $normalizedPath = ltrim(str_replace('\\', '/', $path), '/');
        $url = asset($normalizedPath);
        $absolutePath = public_path($normalizedPath);

        // Use file mtime when the asset is local
        if (is_file($absolutePath)) {
            return self::appendVersion($url, (string) filemtime($absolutePath));
        }

        $assetVersion = config('app.asset_version');

        // Fall back to a shared deploy version for remote files
        return is_string($assetVersion) && $assetVersion !== ''
            ? self::appendVersion($url, $assetVersion)
            : $url;
    }

    private static function appendVersion(string $url, string $version): string
    {
        $separator = str_contains($url, '?') ? '&' : '?';

        return "{$url}{$separator}v={$version}";
    }
}
