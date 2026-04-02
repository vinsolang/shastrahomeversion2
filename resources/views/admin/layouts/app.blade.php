<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shastra | Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/logo/Logo_not_text.png') }}">


    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ckeditor.css') }}">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.1/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,100..900;1,9..144,100..900&display=swap"
        rel="stylesheet">

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</head>

<body style='font-family: "Fraunces", serif;'>
    <div class="">
        <div id="sidebar-backdrop" class="fixed inset-0 bg-black/30 hidden z-40 sm:hidden"></div>
        <nav class="sidebar py-[2px] sm:py-[10px] px-[4px] sm:px-[14px] z-50">
            <header>
                <div class="image-text">
                    <span class="image">
                        <img src="{{ asset('assets/logo/Logo_not_text.png') }}" alt="">
                    </span>

                    <div class="text header-text">
                        <span class="name uppercase">Shastra</span>
                    </div>
                </div>

                <div class="hidden sm:block">
                    <i class="bx bx-chevron-right toggle"></i>
                </div>
            </header>

            <div class="menu-bar">
                <div class="menu max-h-[80vh] overflow-y-auto scrollbar-hidden">
                    <div class="menu-group">
                        <ul class="manu-links">
                            <li class="nav-link {{ Route::is('dashboard') ? 'bg-[#000] rounded-md !text-[#ffffff]' : '' }}">
                                <a href="{{ route('dashboard') }}" class="{{ Route::is('dashboard') ? 'active' : '' }}">
                                    <i class='bx bxs-dashboard icon'></i>
                                    <span class="text nav-text">Dashboard</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="menu-group">
                        <p class="menu-group-label">Pages</p>
                        <ul class="manu-links">
                            <li class="nav-link {{ Request::is('settings/global') ? 'bg-[#000] rounded-md !text-[#ffffff]' : '' }}">
                                <a href="{{ route('cms.settings.edit') }}">
                                    <i class='bx bx-cog icon'></i>
                                    <span class="text nav-text">Global Settings</span>
                                </a>
                            </li>

                            <li class="nav-link {{ Request::is('pages/home') ? 'bg-[#000] rounded-md !text-[#ffffff]' : '' }}">
                                <a href="{{ route('cms.pages.edit', ['page' => 'home']) }}">
                                    <i class='bx bx-home-alt icon'></i>
                                    <span class="text nav-text">Home</span>
                                </a>
                            </li>

                            <li class="nav-link {{ Request::is('pages/contact') ? 'bg-[#000] rounded-md !text-[#ffffff]' : '' }}">
                                <a href="{{ route('cms.pages.edit', ['page' => 'contact']) }}">
                                    <i class='bx bx-envelope icon'></i>
                                    <span class="text nav-text">Contact</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="menu-group">
                        <p class="menu-group-label">Content</p>
                        <ul class="manu-links">
                            <li class="nav-link {{ Request::is('about') || Request::is('about/*') ? 'bg-[#000] rounded-md !text-[#ffffff]' : '' }}">
                                <a href="{{ route('about.index') }}">
                                    <i class='bx bx-male-female icon'></i>
                                    <span class="text nav-text">About</span>
                                </a>
                            </li>

                            <li class="nav-link {{ Request::is('why') ? 'bg-[#000] rounded-md !text-[#ffffff]' : '' }}">
                                <a href="{{ url('why') }}">
                                    <i class='bx bx-wrench icon'></i>
                                    <span class="text nav-text">Services</span>
                                </a>
                            </li>

                            <li class="nav-link {{ Request::is('banner') ? 'bg-[#000] rounded-md !text-[#ffffff]' : '' }}">
                                <a href="{{ url('banner') }}">
                                    <i class='bx bx-video icon'></i>
                                    <span class="text nav-text">Video Footage</span>
                                </a>
                            </li>

                            <li class="nav-link {{ Request::is('category') ? 'bg-[#000] rounded-md !text-[#ffffff]' : '' }}">
                                <a href="{{ url('category') }}">
                                    <i class='bx bx-category icon'></i>
                                    <span class="text nav-text">Category</span>
                                </a>
                            </li>

                            <li class="nav-link {{ Request::is('projects') || Request::is('projects/*') ? 'bg-[#000] rounded-md !text-[#ffffff]' : '' }}">
                                <a href="{{ url('projects') }}">
                                    <i class='bx bx-sitemap icon' ></i>
                                    <span class="text nav-text">Project</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="bottom-content">
                    <li class="">
                        <a href="{{ route('profile.edit') }}">
                            <i class="bx bx-user-circle icon"></i>
                            <span class="text nav-text">Profile</span>
                        </a>
                    </li>

                    <li class="">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="bx bx-log-out icon"></i>
                                <span class="text nav-text">Logout</span>
                            </a>
                        </form>
                    </li>
                </div>
            </div>
        </nav>

        <section class="home">
            <div class="px-[20px] py-[8px] flex items-center gap-3 border-b border-gray-200 bg-white">
                <button id="mobile-sidebar-toggle" type="button"
                    class="sm:hidden inline-flex items-center justify-center w-9 h-9 rounded-md border border-gray-300 text-gray-700">
                    <i class="bx bx-menu"></i>
                </button>
                <div class="text text-[20px] sm:text-[25px] md:text-[30px]">
                @yield('header')
                </div>
            </div>
            <div class="px-[10px] xl:px-[20px] py-[8px] text-[#707070]">
                @yield('content')
            </div>
        </section>
    </div>

    {{-- <div class="md:hidden w-full h-full bg-gray-700 flex flex-col items-center justify-center space-y-2">
        <img src="{{ asset('assets/images/window.png') }}" alt="" class="w-52 h-auto">
        <h1 class="text-[25px] text-[#fff] font-[600] tracking-wider">Window too small</h1>
    </div> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    @yield('js')
    <script>
        // delete message
        function deleteRecord(url) {
            Swal.fire({
                title: "Delete this record?",
                text: "This action cannot be undone.",
                showCancelButton: true,
                confirmButtonColor: "#FF3217",
                cancelButtonColor: "#d33",
                confirmButtonText: "Delete",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Record deleted",
                        text: "The record was deleted successfully.",
                        icon: "success"
                    }).then((result) => {
                        if (result.isConfirmed || result.dismiss === Swal.DismissReason.backdrop) {
                            window.location.href = url;
                        }
                    })
                }
            });
        }
    </script>
</body>

</html>
