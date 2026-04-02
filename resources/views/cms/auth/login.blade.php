<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Shastra CMS Login</title>
<<<<<<< ours
=======
        <link rel="icon" type="image/png" href="{{ asset('assets/logo/Logo_not_text.png') }}">
        <link rel="shortcut icon" href="{{ asset('assets/logo/Logo_not_text.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('assets/logo/Logo_not_text.png') }}">
>>>>>>> theirs

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-950 text-white antialiased">
        <main class="flex min-h-screen items-center justify-center px-6 py-10">
            {{-- CMS login panel --}}
            <section class="w-full max-w-md rounded-[2rem] border border-white/10 bg-white/8 p-8 shadow-2xl backdrop-blur-sm">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-amber-400">CMS Access</p>
                    <h1 class="mt-3 text-3xl font-semibold tracking-tight text-white">Sign in to Shastra CMS</h1>
                    <p class="mt-3 text-sm text-white/70">
                        Use an admin account to manage global settings, page content, and contact submissions.
                    </p>
                </div>

                @if ($errors->any())
                    <div class="mt-6 rounded-2xl border border-rose-300/40 bg-rose-500/10 px-4 py-3 text-sm text-rose-100">
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- CMS login form --}}
                <form method="POST" action="{{ route('cms.login.store') }}" class="mt-6 space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-white/84">Email address</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            class="mt-2 block w-full rounded-2xl border border-white/12 bg-slate-950/50 px-4 py-3 text-sm text-white outline-none transition focus:border-amber-400"
                        >
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-white/84">Password</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            class="mt-2 block w-full rounded-2xl border border-white/12 bg-slate-950/50 px-4 py-3 text-sm text-white outline-none transition focus:border-amber-400"
                        >
                    </div>

                    <label class="flex items-center gap-3 text-sm text-white/72">
                        <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-white/20 bg-slate-950/50 text-amber-400">
                        <span>Keep me signed in</span>
                    </label>

                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center rounded-full bg-amber-500 px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-amber-400"
                    >
                        Sign in
                    </button>
                </form>
            </section>
        </main>
    </body>
</html>
