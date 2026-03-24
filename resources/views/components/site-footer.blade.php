@props([
    'brand',
    'navigation' => [],
    'contact' => [],
    'footer' => [],
])

@php
    $cta = $footer['cta'] ?? [];
    $team = $footer['team'] ?? [];
    $companyLinks = $footer['company_links'] ?? $navigation;
    $footerContact = $footer['contact'] ?? $contact;
    $logoPlaceholders = data_get($footer, 'logo_strip.items', []);
    $legalLinks = data_get($footer, 'legal.links', []);
    $socialIconImages = [
        'facebook' => 'assets/images/Social media/FB.png',
        'tiktok' => 'assets/images/Social media/TT.png',
        'instagram' => 'assets/images/Social media/IG.png',
        'telegram' => 'assets/images/Social media/TG.png',
    ];
    $versionedAsset = static function (string $path): string {
        return \App\Support\VersionedAsset::url($path);
    };
    $ctaHeadline = $cta['headline'] ?? '';
    $ctaHeadlineEmphasis = $cta['emphasis'] ?? null;
    $ctaHeadlineHasEmphasis = filled($ctaHeadlineEmphasis) && str_contains($ctaHeadline, $ctaHeadlineEmphasis);
    $ctaRouteName = $cta['button_route'] ?? null;
    $ctaHref = filled($ctaRouteName) && \Illuminate\Support\Facades\Route::has($ctaRouteName)
        ? route($ctaRouteName)
        : '#';
@endphp

<footer id="contact" class="site-footer">
    {{-- CTA --}}
    <section class="site-footer-cta">
        <div class="site-footer-shell relative overflow-hidden">
            @if (filled($cta['background_image'] ?? null))
                <img
                    src="{{ asset($cta['background_image']) }}"
                    alt=""
                    class="absolute inset-0 h-full w-full object-cover"
                    loading="lazy"
                    decoding="async"
                >
            @endif

            <div class="site-footer-cta__overlay"></div>

            <div class="site-footer-cta__content" data-aos="fade-up" data-aos-duration="720">
                <h2 class="site-footer-cta__headline">
                    @if ($ctaHeadlineHasEmphasis)
                        {{ \Illuminate\Support\Str::before($ctaHeadline, $ctaHeadlineEmphasis) }}<span class="site-footer-cta__headline-emphasis">{{ $ctaHeadlineEmphasis }}</span>{{ \Illuminate\Support\Str::after($ctaHeadline, $ctaHeadlineEmphasis) }}
                    @else
                        {{ $ctaHeadline }}
                    @endif
                    <span class="text-[#ff9808]">{{ $cta['accent'] ?? '' }}</span>
                </h2>

                @if (filled($cta['button_label'] ?? null))
                    <a href="{{ $ctaHref }}" class="site-footer-cta__button">
                        {{ $cta['button_label'] }}
                    </a>
                @endif
            </div>
        </div>
    </section>

    {{-- Team --}}
    <section class="site-footer-team">
        <div class="site-footer-shell">
            <div class="site-footer-team__grid">
                <div class="site-footer-team__visual" data-aos="fade-right" data-aos-duration="760">
                    <div class="site-footer-team__label">
                        @if (filled($team['eyebrow'] ?? null))
                            <p class="site-footer-team__eyebrow">{{ $team['eyebrow'] }}</p>
                        @endif

                        @if (filled($team['caption'] ?? null))
                            <p class="site-footer-team__caption">{{ $team['caption'] }}</p>
                        @endif
                    </div>

                    @if (filled($team['image'] ?? null))
                        <img
                            src="{{ asset($team['image']) }}"
                            alt="{{ $brand['name'] }} team"
                            class="site-footer-team__image"
                            loading="lazy"
                            decoding="async"
                        >
                    @endif
                </div>

                <div class="site-footer-team__copy" data-aos="fade-left" data-aos-duration="760" data-aos-delay="90">
                    @foreach ($team['message'] ?? [] as $line)
                        <span>{{ $line }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Logo strip --}}
    <section class="site-footer-logo-strip" aria-label="Future partner logos">
        <!-- <div class="site-footer-shell">
            <div class="site-footer-logo-grid" data-aos="fade-up" data-aos-duration="720">
                @foreach ($logoPlaceholders as $item)
                    <div class="site-footer-logo-cell">
                        <div class="site-footer-logo-placeholder" aria-hidden="true"></div>
                        @if (filled($item['label'] ?? null))
                            <span class="sr-only">{{ $item['label'] }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div> -->
    </section>

    {{-- Footer meta --}}
    <section class="site-footer-meta">
        <div class="site-footer-shell">
            <div class="site-footer-panel" data-aos="fade-up" data-aos-duration="760">
                <div class="site-footer-panel__grid">
                    <div class="space-y-8">
                        <div class="space-y-6">
                            <h2 class="site-footer-panel__brand">{{ $footer['description_heading'] ?? $brand['name'] }}</h2>

                            <div class="site-footer-panel__body space-y-7">
                                @foreach ($footer['description'] ?? [] as $paragraph)
                                    <p>{{ $paragraph }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="site-footer-panel__column">
                        <h3 class="site-footer-panel__heading">Company</h3>

                        <nav class="site-footer-link-list" aria-label="Footer company navigation">
                            @foreach ($companyLinks as $item)
                                @php
                                    $routeName = $item['route'] ?? null;
                                    $linkHref = filled($routeName) && \Illuminate\Support\Facades\Route::has($routeName)
                                        ? route($routeName)
                                        : ($item['href'] ?? null);
                                @endphp

                                @if (filled($linkHref))
                                    <a href="{{ $linkHref }}">{{ $item['label'] }}</a>
                                @else
                                    <span>{{ $item['label'] }}</span>
                                @endif
                            @endforeach
                        </nav>
                    </div>

                    <div class="site-footer-panel__column">
                        <h3 class="site-footer-panel__heading">Contact</h3>

                        <div class="site-footer-contact-list">
                            <div>
                                @foreach ($footerContact['address_lines'] ?? [] as $line)
                                    <p>{{ $line }}</p>
                                @endforeach
                            </div>

                            <div class="space-y-1">
                                @foreach ($footerContact['phones'] ?? [] as $phone)
                                    @php
                                        $phoneHref = preg_replace('/(?!^\+)[^\d]/', '', $phone);
                                    @endphp

                                    <a href="tel:{{ $phoneHref }}" class="block">
                                        {{ $phone }}
                                    </a>
                                @endforeach
                            </div>

                            @if (filled($footerContact['email'] ?? null))
                                <a href="mailto:{{ $footerContact['email'] }}" class="site-footer-contact-email">
                                    {{ $footerContact['email'] }}
                                </a>
                            @endif
                        </div>

                        <div class="space-y-5">
                            <p class="site-footer-social-title">Follow us on</p>

                            <div class="site-footer-social-list">
                                @foreach ($footerContact['socials'] ?? [] as $social)
                                    @php
                                        $socialHref = $social['href'] ?? null;
                                        $socialIconPath = $socialIconImages[$social['icon']] ?? null;
                                    @endphp

                                    @if (filled($socialHref))
                                        <a
                                            href="{{ $socialHref }}"
                                            class="site-footer-social-link"
                                            aria-label="{{ $social['label'] }}"
                                            target="_blank"
                                            rel="noreferrer noopener"
                                        >
                                            @if ($socialIconPath)
                                                <img
                                                    src="{{ $versionedAsset($socialIconPath) }}"
                                                    alt=""
                                                    class="site-footer-social-asset"
                                                    width="134"
                                                    height="134"
                                                    loading="lazy"
                                                    decoding="async"
                                                >
                                            @endif
                                        </a>
                                    @else
                                        <span class="site-footer-social-link" role="img" aria-label="{{ $social['label'] }}">
                                            @if ($socialIconPath)
                                                <img
                                                    src="{{ $versionedAsset($socialIconPath) }}"
                                                    alt=""
                                                    class="site-footer-social-asset"
                                                    width="134"
                                                    height="134"
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
                </div>
            </div>

            <div class="site-footer-legal">
                <p>{{ data_get($footer, 'legal.copyright') }}</p>

                <div class="site-footer-legal__links">
                    @foreach ($legalLinks as $item)
                        @if (filled($item['href'] ?? null))
                            <a href="{{ $item['href'] }}">{{ $item['label'] }}</a>
                        @else
                            <span class="site-footer-legal__placeholder">{{ $item['label'] }}</span>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</footer>
