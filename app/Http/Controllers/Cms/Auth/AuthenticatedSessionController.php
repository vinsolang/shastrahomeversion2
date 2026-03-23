<?php

declare(strict_types=1);

namespace App\Http\Controllers\Cms\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cms\LoginRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

final class AuthenticatedSessionController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        if ($request->user()?->is_admin) {
            return to_route('cms.dashboard');
        }

        return view('cms.auth.login');
    }

    /**
     * @throws ValidationException
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        abort_unless($request->user() !== null, 500);

        if (! $request->user()->is_admin) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => 'This account does not have CMS access.',
            ]);
        }

        return redirect()->intended(route('cms.dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('cms.login');
    }
}
