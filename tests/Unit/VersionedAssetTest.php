<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Support\VersionedAsset;
use Tests\TestCase;

final class VersionedAssetTest extends TestCase
{
    public function test_it_appends_the_local_file_mtime_when_the_asset_exists(): void
    {
        $url = VersionedAsset::url('favicon.ico');

        $this->assertStringStartsWith(asset('favicon.ico') . '?v=', $url);
    }

    public function test_it_falls_back_to_the_configured_asset_version_for_remote_assets(): void
    {
        config()->set('app.asset_url', 'https://cdn.example.com');
        config()->set('app.asset_version', '20260323');

        $url = VersionedAsset::url('assets/videos/remote-video.mp4');

        $this->assertSame(
            'https://cdn.example.com/assets/videos/remote-video.mp4?v=20260323',
            $url,
        );
    }
}
