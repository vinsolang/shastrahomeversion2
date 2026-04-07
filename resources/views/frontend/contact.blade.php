{{-- Contact Page  --}}
@extends('layouts.marketing')

@section('title', 'Shastra | ' . $page['title'])
@section('meta_description', $page['description'])

@section('content')
    @php
        $hero = $page['hero'] ?? [];
        $form = $page['form'] ?? [];
        $siteContact = $site['contact'] ?? [];
        $heroVideo = $hero['video'] ?? null;
        $heroPoster = $hero['poster'] ?? null;
        $firstNameField = data_get($form, 'fields.first_name', []);
        $lastNameField = data_get($form, 'fields.last_name', []);
        $emailField = data_get($form, 'fields.email_address', []);
        $projectTypeField = data_get($form, 'fields.project_type', []);
        $messageField = data_get($form, 'fields.message', []);
        $projectTypeOptions = $projectTypeField['options'] ?? [];
        $contactMapUrl = $siteContact['map_url'] ?? null;
        $contactMapLabel = $siteContact['map_label'] ?? 'Open in Google Maps';
        $contactPhoneLine = collect($siteContact['phones'] ?? [])
            ->filter(static fn (?string $phone): bool => filled($phone))
            ->implode(' / ');
        $detailItems = array_values(array_filter([
            [
                'lines' => $siteContact['address_lines'] ?? [],
                'href' => $contactMapUrl,
                'link_label' => $contactMapLabel,
            ],
            [
                'lines' => array_values(array_filter([
                    $contactPhoneLine,
                    $siteContact['hours'] ?? null,
                ], static fn (?string $value): bool => filled($value))),
            ],
        ], static fn (array $item): bool => ($item['lines'] ?? []) !== []));
    @endphp

    <div class="bg-white text-[#1f1f1f]">
        {{-- Hero --}}
        <section class="overflow-hidden bg-white pb-[clamp(4rem,7vw,6rem)]">
            <div class="mx-auto max-w-[1904px]">
                <div class="contact-stage overflow-visible bg-white">
                    <div class="relative min-h-[21rem] overflow-hidden bg-[#121212] sm:min-h-[25rem] lg:h-[30rem] lg:min-h-[30rem] lg:overflow-visible xl:h-[31rem] xl:min-h-[31rem]">
                        @if (filled($heroVideo))
                            <div class="absolute inset-0 overflow-hidden" data-aos="fade-left" data-aos-duration="780">
                                <video
                                    class="contact-stage__video absolute inset-0 h-full w-full object-cover object-[60%_center] sm:object-[58%_center] lg:object-[50%_center]"
                                    autoplay
                                    muted
                                    loop
                                    playsinline
                                    data-start-time="40"
                                    preload="auto"
                                    @if (filled($heroPoster))
                                        poster="{{ asset($heroPoster) }}"
                                    @endif
                                >
                                    <source src="{{ asset($heroVideo) }}" type="video/mp4">
                                </video>
                            </div>
                        @endif

                        <div class="relative z-20 px-4 pt-8 pb-8 sm:px-6 sm:pt-10 sm:pb-10 lg:absolute lg:inset-x-0 lg:top-[3.2rem] lg:px-0 lg:pt-0 lg:pb-0 xl:top-[3.5rem]">
                            <div class="lg:ml-[8.75rem] xl:ml-[10.25rem]">
                                <article class="contact-stage__panel relative max-w-[46rem] bg-[rgba(14,14,14,0.86)] px-5 py-6 text-white sm:px-7 sm:py-8 lg:max-w-[58rem] lg:px-[2rem] lg:py-[2.25rem] xl:max-w-[58rem] xl:px-[2.35rem] xl:py-[2.45rem]" data-aos="fade-up" data-aos-duration="760">
                                    <div class="absolute left-0 top-[1.6rem] h-[5rem] w-[0.85rem] bg-[#ff8800] sm:top-[1.9rem] sm:h-[5.7rem] lg:h-[6.15rem]" aria-hidden="true"></div>

                                    <div class="pl-[1.15rem] sm:pl-[1.4rem]">
                                        <p class="text-[0.72rem] font-medium uppercase tracking-[0.42em] text-[#ff8800] sm:text-[0.8rem]">
                                            {{ $hero['eyebrow'] ?? '' }}
                                        </p>

                                        <h1 class="mt-4 max-w-[34rem] font-sans text-[2.35rem] leading-[0.94] font-light tracking-[-0.05em] text-white sm:text-[3rem] lg:text-[4rem] xl:text-[4.35rem]">
                                            {{ $hero['headline'] ?? '' }}<span class="text-[#ff8800]">{{ $hero['accent'] ?? '' }}</span>
                                        </h1>

                                        <p class="mt-4 max-w-[30rem] text-[0.92rem] leading-[1.28] text-white/78 sm:text-[1rem] lg:text-[1.05rem]">
                                            {{ $hero['description'] ?? '' }}
                                        </p>

                                        <div class="mt-7">
                                            <h2 class="text-[1.45rem] font-semibold text-[#ff8800] sm:text-[1.75rem]">
                                                {{ $form['title'] ?? '' }}
                                            </h2>
                                        </div>

                                        @if (session('contact_form_status'))
                                            <div class="contact-feedback contact-feedback--success mt-4" role="status">
                                                {{ session('contact_form_status') }}
                                            </div>
                                        @endif

                                        @if ($errors->any())
                                            <div class="contact-feedback contact-feedback--error mt-4" role="alert">
                                                Please correct the highlighted fields and try again.
                                            </div>
                                        @endif

                                        {{-- Form --}}
                                        <form method="POST" id="contactForm" action="{{ route('contact.telegram') }}" aria-label="Contact us inquiry form" class="mt-4" novalidate>
                                            @csrf
                                            <div class="grid gap-3 sm:grid-cols-2">
                                                <label class="block">
                                                    <span class="sr-only">Full Name</span>
                                                    <input
                                                        type="text"
                                                        name="first_name"
                                                        autocomplete="{{ $firstNameField['autocomplete'] ?? 'given-name' }}"
                                                        placeholder="Full Name"
                                                        value="{{ old('first_name') }}"
                                                        required
                                                        @class([
                                                            'contact-field',
                                                            'contact-field--invalid' => $errors->has('first_name'),
                                                        ])
                                                        aria-invalid="{{ $errors->has('first_name') ? 'true' : 'false' }}"
                                                    >

                                                    @error('first_name')
                                                        <p class="contact-field-error mt-2">{{ $message }}</p>
                                                    @enderror
                                                </label>

                                                <label class="block">
                                                    <span class="sr-only">Phone Number</span>
                                                    <input
                                                        type="text"
                                                        name="phone_number"
                                                        autocomplete="{{ $lastNameField['autocomplete'] ?? 'family-name' }}"
                                                        placeholder="Phone Number"
                                                        value="{{ old('phone_number') }}"
                                                        required
                                                        @class([
                                                            'contact-field',
                                                            'contact-field--invalid' => $errors->has('phone_number'),
                                                        ])
                                                        aria-invalid="{{ $errors->has('phone_number') ? 'true' : 'false' }}"
                                                    >

                                                    @error('phone_number')
                                                        <p class="contact-field-error mt-2">{{ $message }}</p>
                                                    @enderror
                                                </label>
                                            </div>

                                            <div class="mt-3 grid gap-3">
                                                <label class="block">
                                                    <span class="sr-only">Email Address</span>
                                                    <input
                                                        type="email"
                                                        name="email_address"
                                                        autocomplete="{{ $emailField['autocomplete'] ?? 'email' }}"
                                                        placeholder="Email Address"
                                                        value="{{ old('email_address') }}"
                                                        required
                                                        @class([
                                                            'contact-field',
                                                            'contact-field--invalid' => $errors->has('email_address'),
                                                        ])
                                                        aria-invalid="{{ $errors->has('email_address') ? 'true' : 'false' }}"
                                                    >

                                                    @error('email_address')
                                                        <p class="contact-field-error mt-2">{{ $message }}</p>
                                                    @enderror
                                                </label>

                                                <label class="relative block">
                                                    <span class="sr-only">Project Type</span>
                                                    <select
                                                        name="project_type"
                                                        required
                                                        @class([
                                                            'contact-field contact-select pr-10 text-white/78',
                                                            'contact-field--invalid' => $errors->has('project_type'),
                                                        ])
                                                        aria-invalid="{{ $errors->has('project_type') ? 'true' : 'false' }}"
                                                    >
                                                        <option value="" @selected(old('project_type') === null) disabled>{{ $projectTypeField['placeholder'] ?? '' }}</option>
                                                        @foreach ($projectTypeOptions as $option)
                                                            <option value="{{ $option }}" @selected(old('project_type') === $option)>{{ $option }}</option>
                                                        @endforeach
                                                    </select>

                                                    <span class="pointer-events-none absolute inset-y-0 right-0 flex w-12 items-center justify-center" aria-hidden="true">
                                                        <img
                                                            src="{{ asset('assets/images/About us/arrow-dropdown.svg') }}"
                                                            alt=""
                                                            class="h-3.5 w-3.5 object-contain"
                                                            loading="lazy"
                                                            decoding="async"
                                                        >
                                                    </span>

                                                    @error('project_type')
                                                        <p class="contact-field-error mt-2">{{ $message }}</p>
                                                    @enderror
                                                </label>

                                                <label class="block">
                                                    <span class="sr-only">Message</span>
                                                    <textarea
                                                        name="message"
                                                        rows="{{ $messageField['rows'] ?? 5 }}"
                                                        placeholder="Message"
                                                        
                                                        @class([
                                                            'contact-field contact-textarea',
                                                            'contact-field--invalid' => $errors->has('message'),
                                                        ])
                                                        aria-invalid="{{ $errors->has('message') ? 'true' : 'false' }}"
                                                    >{{ old('message') }}</textarea>

                                                    @error('message')
                                                        <p class="contact-field-error mt-2">{{ $message }}</p>
                                                    @enderror
                                                </label>
                                            </div>

                                            <button type="submit" class="contact-submit mt-4">
                                                {{ $form['submit_label'] ?? '' }}
                                            </button>
                                        </form>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>

                    {{-- Details --}}
                    <div class="relative z-0 bg-white px-4 pt-3 pb-4 sm:px-6 lg:px-0 lg:pt-[15rem] lg:pb-0 xl:pt-[15.75rem]">
                        <div class="lg:ml-[8.75rem] xl:ml-[10.25rem]">
                            <div class="mt-5 max-w-[46rem] px-1 text-[0.72rem] leading-[1.45] text-[#8a8a8a] sm:grid sm:grid-cols-[1.25fr_1.45fr] sm:gap-x-6 sm:gap-y-0 lg:mt-7 lg:max-w-[58rem] lg:text-[0.78rem] xl:max-w-[58rem]">
                                @foreach ($detailItems as $item)
                                    <div
                                        @class([
                                            'mt-3 sm:mt-0' => ! $loop->first,
                                            'sm:pl-4 lg:pl-6 whitespace-nowrap' => $loop->iteration === 2,
                                        ])
                                    >
                                        @if (filled($item['href'] ?? null))
                                            <a
                                                href="{{ $item['href'] }}"
                                                class="inline-flex flex-col gap-0.5 transition hover:text-[#5f5f5f]"
                                                target="_blank"
                                                rel="noreferrer noopener"
                                            >
                                                @foreach ($item['lines'] ?? [] as $line)
                                                    <p>{{ $line }}</p>
                                                @endforeach

                                                @if (filled($item['link_label'] ?? null))
                                                    <span class="mt-2 text-[0.7rem] font-medium uppercase tracking-[0.22em] text-[#ff8800]">
                                                        {{ $item['link_label'] }}
                                                    </span>
                                                @endif
                                            </a>
                                        @else
                                            @foreach ($item['lines'] ?? [] as $line)
                                                <p>{{ $line }}</p>
                                            @endforeach
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Media --}}
        @include('frontend.partials.media-section', [
            // 'media' => $page['media'] ?? [],
            // 'sectionClass' => 'overflow-hidden bg-white pb-0',
               'media' => $media,
        ])
    </div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('contactForm');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(form);

        fetch(form.action, {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {

            if (data.url) {
                window.location.href = data.url; 
                // OR open new tab:
                // window.open(data.url, '_blank');
            }

        })
        .catch(err => console.log(err));
    });

});
</script>