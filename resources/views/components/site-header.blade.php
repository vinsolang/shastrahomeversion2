@props([
    'brand',
    'navigation' => [],
    'contact' => [],
])

@php
    $desktopNavClasses = 'group hidden h-full w-max items-center justify-center self-stretch justify-self-center gap-[clamp(24px,2.3vw,44px)] xl:gap-[clamp(34px,3.5vw,72px)] lg:flex';
    $desktopLinkBaseClasses = 'relative inline-flex h-full items-center justify-center px-[0.55rem] text-center text-[15px] leading-none text-[var(--navbar-ink)] after:absolute after:inset-x-0 after:bottom-0 after:h-1 after:origin-center after:scale-x-0 after:bg-[var(--navbar-accent)] after:transition-transform after:duration-200';
    $desktopLinkActiveClasses = 'font-bold after:scale-x-100 lg:group-hover:after:scale-x-0 lg:hover:after:scale-x-100';
    $desktopLinkInactiveClasses = 'font-normal hover:after:scale-x-100';
    $brandImageClasses = 'h-[28px] w-[162px] shrink-0 object-contain object-left sm:h-[32px] sm:w-[185px] lg:h-[38px] lg:w-auto';
    $mobileMenuToggleClasses = 'group relative ml-auto inline-flex h-10 w-10 shrink-0 items-center justify-center bg-transparent transition-transform duration-200 ease-out hover:scale-[1.04] lg:hidden';
    $desktopMenuToggleClasses = 'group relative ml-auto hidden h-10 w-10 shrink-0 items-center justify-center bg-transparent transition-transform duration-200 ease-out hover:scale-[1.04] lg:justify-self-end lg:inline-flex';
    $menuToggleBarClasses = 'absolute left-1/2 h-[2.5px] w-6 -translate-x-1/2 rounded-full bg-[var(--navbar-accent)] transition-all duration-200 ease-out group-hover:w-[26px]';
    $drawerSocialButtonClasses = 'inline-flex h-11 w-11 items-center justify-center bg-transparent p-0 transition-transform duration-200 ease-out hover:-translate-y-0.5 sm:h-[42px] sm:w-[42px]';
    $drawerSocialIconClasses = 'block h-full w-full shrink-0 object-contain';
    $socialIconImages = [
        'facebook' => 'assets/images/Social media/FB.webp',
        'tiktok' => 'assets/images/Social media/TT.png',
        'instagram' => 'assets/images/Social media/IG.png',
        'telegram' => 'assets/images/Social media/TG.png',
    ];
    $versionedAsset = static function (string $path): string {
        return \App\Support\VersionedAsset::url($path);
    };
@endphp

{{-- Site header --}}
<header x-data="siteHeader()" @keydown.escape.window="open = false" class="sticky top-0 z-50 border-b border-black/8 bg-[var(--navbar-surface)]">
    <div class="mx-auto flex h-[62px] max-w-[1904px] items-center justify-between gap-3 px-4 sm:gap-4 sm:px-5 lg:grid lg:grid-cols-[auto_minmax(0,1fr)_auto] lg:justify-normal lg:gap-6 lg:px-[38px]">
        {{-- Brand --}}
        <a href="{{ route('home') }}" class="flex items-center">
            <img src="{{ asset('assets/images/Shastra-Logo.png') }}" alt="{{ $brand['name'] }} logo" class="{{ $brandImageClasses }}">
        </a>

        {{-- Nav --}}
        <nav class="{{ $desktopNavClasses }}">
            @foreach ($navigation as $item)
                @php
                    $routeName = $item['route'];
                    $isActive = request()->routeIs($routeName);
                @endphp

                <a
                    href="{{ route($routeName) }}"
                    @class([
                        $desktopLinkBaseClasses,
                        $isActive ? $desktopLinkActiveClasses : $desktopLinkInactiveClasses,
                    ])
                >
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        {{-- Mobile toggle --}}
        <button
            type="button"
            class="{{ $mobileMenuToggleClasses }}"
            @click="open = ! open"
            :aria-expanded="open.toString()"
            :aria-label="open ? 'Close menu' : 'Open menu'"
        >
            <span class="{{ $menuToggleBarClasses }} -translate-y-[7px]"></span>
            <span class="{{ $menuToggleBarClasses }}"></span>
            <span class="{{ $menuToggleBarClasses }} translate-y-[7px]"></span>
        </button>

        {{-- Desktop toggle --}}
        <button
            type="button"
            class="{{ $desktopMenuToggleClasses }}"
            @click="open = ! open"
            :aria-expanded="open.toString()"
            :aria-label="open ? 'Close menu' : 'Open menu'"
        >
            <span class="{{ $menuToggleBarClasses }} -translate-y-[7px]"></span>
            <span class="{{ $menuToggleBarClasses }}"></span>
            <span class="{{ $menuToggleBarClasses }} translate-y-[7px]"></span>
        </button>
    </div>

    {{-- Backdrop --}}
    <div
        x-cloak
        x-show="open"
        x-transition.opacity
        class="fixed inset-x-0 bottom-0 top-[62px] z-[60] bg-transparent"
        @click="open = false"
    ></div>

    {{-- Drawer --}}
    <aside
        x-cloak
        x-show="open"
        x-transition:enter="transition duration-300 ease-out"
        x-transition:enter-start="translate-x-full opacity-0"
        x-transition:enter-end="translate-x-0 opacity-100"
        x-transition:leave="transition duration-200 ease-in"
        x-transition:leave-start="translate-x-0 opacity-100"
        x-transition:leave-end="translate-x-full opacity-0"
        class="fixed right-0 top-[62px] z-[70] flex h-[calc(100vh-62px)] max-h-[864px] w-[min(426px,92vw)] flex-col overflow-y-auto bg-[rgba(30,30,30,0.95)] px-6 pb-8 pt-6 text-white shadow-2xl sm:px-8 sm:pb-10 sm:pt-8 lg:w-[426px]"
    >
        <div>
            <button
                type="button"
                class="flex h-10 w-10 items-center justify-center text-white/90 transition hover:text-white"
                @click="open = false"
                aria-label="Close menu"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.25" d="M6 6l12 12M18 6L6 18" />
                </svg>
            </button>
        </div>

        <nav class="mt-10 flex flex-col gap-2 border-t border-white/10 pt-8 lg:hidden" aria-label="Primary navigation">
            @foreach ($navigation as $item)
                @php
                    $routeName = $item['route'];
                    $isActive = request()->routeIs($routeName);
                @endphp

                <a
                    href="{{ route($routeName) }}"
                    @click="open = false"
                    @class([
                        'rounded-full px-4 py-3 text-base font-medium text-white/82 transition hover:bg-white/6 hover:text-white',
                        'bg-white/10 text-white' => $isActive,
                    ])
                >
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        {{-- Drawer contact --}}
        <div class="mt-10 pb-4 sm:mt-auto">
            <p class="text-[18px] font-semibold text-[#FF8800]">Contact</p>
            <div class="mt-4 text-[14px] leading-7 text-white/82">
                <div>
                    @if (filled($contact['map_url'] ?? null))
                        <a
                            href="{{ $contact['map_url'] }}"
                            class="block space-y-1 transition hover:text-white"
                            target="_blank"
                            rel="noreferrer noopener"
                        >
                            @foreach ($contact['address_lines'] ?? [] as $line)
                                <p>{{ $line }}</p>
                            @endforeach
                        </a>
                    @else
                        @foreach ($contact['address_lines'] ?? [] as $line)
                            <p>{{ $line }}</p>
                        @endforeach
                    @endif
                </div>

                <div class="mt-5">
                    @foreach ($contact['phones'] ?? [] as $phone)
                        @php
                            $phoneHref = preg_replace('/(?!^\+)[^\d]/', '', $phone);
                        @endphp

                        <a href="tel:{{ $phoneHref }}" class="block">
                            {{ $phone }}
                        </a>
                    @endforeach
                </div>

                <a href="mailto:{{ $contact['email'] }}" class="mt-5 block underline underline-offset-4">
                    {{ $contact['email'] }}
                </a>

                @if (filled($contact['map_url'] ?? null))
                    <a
                        href="{{ $contact['map_url'] }}"
                        class="mt-5 inline-block underline underline-offset-4"
                        target="_blank"
                        rel="noreferrer noopener"
                    >
                        {{ $contact['map_label'] ?? 'Open in Google Maps' }}
                    </a>
                @endif
            </div>

            <div class="mt-10">
                <p class="text-[18px] font-semibold text-[#FF8800]">Follow us on</p>

                <div class="mt-6 flex flex-wrap items-center gap-4">
                    @foreach ($contact['socials'] ?? [] as $social)
                        @php
                            $socialHref = $social['href'] ?? null;
                            $socialIconPath = $socialIconImages[$social['icon']] ?? null;
                        @endphp

                        @if (filled($socialHref))
                            <a
                                href="{{ $socialHref }}"
                                class="{{ $drawerSocialButtonClasses }}"
                                aria-label="{{ $social['label'] }}"
                                target="_blank"
                                rel="noreferrer noopener"
                                @click="open = false"
                            >
                                @if ($socialIconPath)
                                    <img
                                        src="{{ $versionedAsset($socialIconPath) }}"
                                        alt=""
                                        class="{{ $drawerSocialIconClasses }}"
                                        width="44"
                                        height="44"
                                        loading="lazy"
                                        decoding="async"
                                    >
                                @endif
                            </a>
                        @else
                            <span class="{{ $drawerSocialButtonClasses }}" role="img" aria-label="{{ $social['label'] }}">
                                @if ($socialIconPath)
                                    <img
                                        src="{{ $versionedAsset($socialIconPath) }}"
                                        alt=""
                                        class="{{ $drawerSocialIconClasses }}"
                                        width="44"
                                        height="44"
                                        loading="lazy"
                                        decoding="async"
                                    >
                                @endif
                            </span>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </aside>
</header>
