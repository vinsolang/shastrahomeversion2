<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class PublicMediaController extends Controller
{
    public function show(string $path): StreamedResponse
    {
        /** @var \Illuminate\Filesystem\FilesystemAdapter $storage */
        $storage = Storage::disk('custom');

        abort_unless($storage->exists($path), Response::HTTP_NOT_FOUND);

        if ($downloadName = request()->query('download_name')) {
            return $storage->download($path, $downloadName);
        }
        return $storage->response($path);
    }
}
