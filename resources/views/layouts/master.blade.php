<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="icon" type="image/png" href="{{ asset('assets/logo/Logo_not_text.png') }}">

    @yield('title')

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Serif:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">
    <!-- Kantumruy Pro -->
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    {{-- aos --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @yield('css')
</head>
<style>
    .text-gradient {
        background: linear-gradient(180deg, #830B00 0%, #966927 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .bg-gradient {
        background: linear-gradient(180deg, #830B00 0%, #966927 100%);
    }

    .bg-gradient1 {
        background: linear-gradient(94deg, #830B00 1.01%, #966927 69.43%);
    }

    .eb{
        font-family: "Montserrat", sans-serif;
    }


    [x-cloak] {
        display: none !important;
    }

    .kantumruy {
        font-family: "Kantumruy Pro", sans-serif;
    }

    .ibm {
        font-family: "IBM Plex Serif", serif;
    }

    .inter {
        font-family: "Inter", sans-serif;
    }


    .prose ul {
        list-style-type: disc;
        padding-left: 1.25rem;
        font-size: 16px;
    }

    .prose ul li::marker {}

    .prose ol {
        list-style-type: decimal;
        padding-left: 1.25rem;
        font-size: 16px;
    }

    .prose p {
        font-size: 16px;
    }

    .prose strong {
        font-size: 18px;
    }

    @media (max-width: 639px) {

        .prose strong {
            font-size: 16px;
        }

        .prose p span {
            font-size: 14px;
        }

        .prose ul {
            list-style-type: disc;
            padding-left: 1.25rem;
            font-size: 14px;
        }
    }
</style>

<body class="{{ app()->getLocale() === 'en' ? 'inter' : 'kantumruy' }}">
    @php
        $locale = app()->getLocale();
    @endphp
    @include('components.navbar')

    @yield('content')

    @if (!Request::is('contact'))
        @include('components.footer')
    @endif


    {{-- aos --}}
    <!-- Swiper JS -->
    @yield('js')
    <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script>
        var swiper = new Swiper(".productSwiper", {
            slidesPerView: 4,
            spaceBetween: 30,
            autoplay: {
                delay: 2000,
            },
            loop: true,
            breakpoints: {
                1280: {
                    slidesPerView: 4,
                },
                1024: {
                    slidesPerView: 3,
                },
                480: {
                    slidesPerView: 2,
                },
                0: {
                    slidesPerView: 1,
                }
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });

        var projectSwiper = new Swiper(".ProjectSwiper", {
            loop: true,
            autoplay: {
                delay: 2000,
            },
            pagination: {
                el: ".swiper-pagination",
            },
        });

        var productSwiper = new Swiper(".ProductSwiper", {
            loop: true,
            autoplay: {
                delay: 2000,
            },
            pagination: {
                el: ".swiper-pagination",
            },
        });

        function contactForm() {
            return {
                form: {
                    name: '',
                    message: '',
                    email: '',
                    telegram: '',
                    consent: false,
                    _token: '{{ csrf_token() }}'
                },
                toast: {
                    show: false,
                    message: '',
                    type: 'success'
                },

                async submitForm() {
                    this.toast.show = false;

                    try {
                        const response = await fetch("{{ route('home.send') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(this.form)
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            throw data;
                        }

                        // ✅ Success toast
                        this.toast.show = true;
                        this.toast.message = data.success;
                        this.toast.type = 'success';

                        // Reset form
                        this.form.name = '';
                        this.form.message = '';
                        this.form.email = '';
                        this.form.telegram = '';
                        this.form.consent = false;

                    } catch (err) {
                        let message = 'Something went wrong';

                        // ✅ Laravel validation errors
                        if (err.errors) {
                            message = Object.values(err.errors).flat().join(' | ');
                        }

                        this.toast.show = true;
                        this.toast.message = message;
                        this.toast.type = 'error';
                    }

                    // Auto hide toast
                    setTimeout(() => {
                        this.toast.show = false;
                    }, 4000);
                }
            }
        }
    </script>


</body>

</html>
