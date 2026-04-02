<?php

namespace App\Http\Controllers;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Sheets;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use RuntimeException;

class GoogleAuthController extends Controller
{
    private function client(): Client
    {
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');
        $redirectUri = config('services.google.redirect_uri');

        if (blank($clientId) || blank($clientSecret) || blank($redirectUri)) {
            throw new RuntimeException('Google OAuth credentials are not configured.');
        }

        $client = new Client();
        $client->setApplicationName('Laravel Google Integration');
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        $client->setScopes([
            Drive::DRIVE,
            Sheets::SPREADSHEETS,
        ]);
        $client->setAccessType('offline');
        $client->setPrompt('consent');

        return $client;
    }

    public function auth(): RedirectResponse
    {
        return redirect()->away($this->client()->createAuthUrl());
    }

    public function callback(Request $request): Response
    {
        $validated = $request->validate([
            'code' => ['required_without:error', 'string'],
            'error' => ['nullable', 'string'],
        ]);

        if (!empty($validated['error'])) {
            return response(
                'Google authorization failed: ' . $validated['error'],
                422
            );
        }

        $token = $this->client()->fetchAccessTokenWithAuthCode($validated['code']);

        if (isset($token['error'])) {
            return response(
                'Google token exchange failed: '
                . ($token['error_description'] ?? $token['error']),
                422
            );
        }

        File::ensureDirectoryExists(storage_path('app/google'));
        File::put(
            storage_path('app/google/token.json'),
            json_encode($token, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );

        return response('Token saved to storage/app/google/token.json.');
    }
}
