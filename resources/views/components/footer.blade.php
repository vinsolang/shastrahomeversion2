<footer class="hidden lg:flex flex-wrap items-start gap-4 px-2 xl:px-10 pb-4 overflow-hidden">
    <div class="w-[15%] text-right pt-16" data-aos="fade-right" data-aos-duration="1400">
        <h1 class="text-[16px] xl:text-[20px] font-bold">V-Arch Lighting</h1>
        <p class="text-[10px] xl:text-[12px] pt-4">
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet
            dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper
            suscipit lobortis nisl ut aliquip ex ea commodo consequat.
        </p>
    </div>
    <div class="w-[15%] text-right pt-16" data-aos="fade-right" data-aos-duration="1400">
        <h1 class="text-[16px] xl:text-[20px] font-bold">{{ app()->getLocale() === 'en' ? 'Information' : (app()->getLocale() === 'km' ? 'ព័ត៌មាន' : 'Information') }}</h1>
        <ul class="text-[12px] xl:text-[14px] pt-4 space-y-1">
            <li class="py-1"><a class="hover:underline transition-all duration-300"
                    href="{{ route('home') }}">{{ app()->getLocale() === 'en' ? 'Home' : (app()->getLocale() === 'km' ? 'ទំព័រដើម' : 'Home') }}</a>
            </li>
            <li class="py-1"><a class="hover:underline transition-all duration-300"
                    href="{{ route('about') }}">{{ app()->getLocale() === 'en' ? 'About Us' : (app()->getLocale() === 'km' ? 'អំពីយើងខ្ញុំ' : 'About Us') }}</a>
            </li>
            <li class="py-1"><a class="hover:underline transition-all duration-300"
                    href="{{ route('product') }}">{{ app()->getLocale() === 'en' ? 'Our Products' : (app()->getLocale() === 'km' ? 'ផលិតផលរបស់យើងខ្ញុំ' : 'Our Products') }}</a>
            </li>
            <li class="py-1"><a class="hover:underline transition-all duration-300"
                    href="{{ route('project') }}">{{ app()->getLocale() === 'en' ? 'Our Projects' : (app()->getLocale() === 'km' ? 'គម្រោងរបស់យើងខ្ញុំ' : 'Our Projects') }}</a>
            </li>
            <li class="py-1"><a class="hover:underline transition-all duration-300"
                    href="{{ route('store') }}">{{ app()->getLocale() === 'en' ? 'Store Location' : (app()->getLocale() === 'km' ? 'ទីតាំងហាង' : 'Store Location') }}</a>
            </li>
            <li class="py-1"><a class="hover:underline transition-all duration-300"
                    href="{{ route('contact') }}">{{ app()->getLocale() === 'en' ? 'Contact Us' : (app()->getLocale() === 'km' ? 'ទំនាក់ទំនងមកយើង' : 'Contact Us') }}</a>
            </li>
        </ul>
    </div>
    <div class="w-[31%] mx-auto" data-aos="fade-up" data-aos-duration="1400">
        <img src="{{ asset('assets/images/lamp-2.png') }}" alt="" class="w-full">
        <div class="flex flex-col gap-4 items-center text-center">
            <h1>Follow Us</h1>
            <div class="flex items-center gap-4">
                <a href="https://www.facebook.com/varch.lighting.52">
                    <svg class="w-10" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M19 0C8.52344 0 0 8.52344 0 19C0 29.4758 8.52344 38 19 38C29.4758 38 38 29.4758 38 19C38 8.52344 29.4773 0 19 0ZM23.7251 19.6689H20.634V30.6865H16.0535C16.0535 30.6865 16.0535 24.6665 16.0535 19.6689H13.8761V15.7749H16.0535V13.2562C16.0535 11.4523 16.9107 8.63365 20.6761 8.63365L24.0703 8.64666V12.4266C24.0703 12.4266 22.0077 12.4266 21.6067 12.4266C21.2057 12.4266 20.6355 12.6271 20.6355 13.4874V15.7757H24.1254L23.7251 19.6689Z"
                            fill="#007BFF" />
                    </svg>

                </a>
                <a href="https://t.me/limvandara_lighting">
                    <svg class="w-10" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M19 38C29.4934 38 38 29.4934 38 19C38 8.50659 29.4934 0 19 0C8.50659 0 0 8.50659 0 19C0 29.4934 8.50659 38 19 38Z"
                            fill="#039BE5" />
                        <path
                            d="M8.69407 18.5891L27.0132 11.5259C27.8635 11.2187 28.6061 11.7333 28.3306 13.019L28.3321 13.0174L25.213 27.7123C24.9818 28.7541 24.3627 29.0075 23.4966 28.5166L18.7466 25.0159L16.4556 27.2231C16.2022 27.4764 15.9885 27.6901 15.4977 27.6901L15.8349 22.8562L24.6382 14.9031C25.0214 14.5659 24.5527 14.3759 24.0476 14.7116L13.1686 21.5611L8.47874 20.0981C7.46066 19.7751 7.43849 19.08 8.69407 18.5891Z"
                            fill="white" />
                    </svg>
                </a>
                <a href="#">
                    <svg class="w-10" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M19 38C29.4934 38 38 29.4934 38 19C38 8.50659 29.4934 0 19 0C8.50659 0 0 8.50659 0 19C0 29.4934 8.50659 38 19 38Z"
                            fill="#29A71A" />
                        <path
                            d="M27.3773 10.6233C25.4005 8.62674 22.7753 7.40234 19.9753 7.17092C17.1752 6.93949 14.3847 7.71627 12.1069 9.36114C9.82915 11.006 8.21416 13.4107 7.55324 16.1414C6.89232 18.8722 7.22898 21.7492 8.5025 24.2536L7.25238 30.3228C7.23941 30.3832 7.23905 30.4456 7.25131 30.5062C7.26357 30.5667 7.28819 30.6241 7.32363 30.6747C7.37556 30.7515 7.44968 30.8107 7.5361 30.8442C7.62252 30.8778 7.71712 30.8842 7.80727 30.8626L13.7556 29.4527C16.2529 30.694 19.1096 31.009 21.8174 30.3417C24.5252 29.6744 26.9085 28.068 28.5431 25.8085C30.1777 23.549 30.9576 20.7828 30.7442 18.0021C30.5307 15.2215 29.3376 12.6068 27.3773 10.6233ZM25.5226 25.426C24.1549 26.7899 22.3936 27.6902 20.4871 28.0001C18.5806 28.3099 16.6248 28.0138 14.8956 27.1532L14.0665 26.743L10.4198 27.6067L10.4306 27.5613L11.1862 23.8909L10.7803 23.0898C9.89675 21.3545 9.58505 19.3841 9.8899 17.4608C10.1947 15.5374 11.1005 13.7599 12.4774 12.3829C14.2075 10.6534 16.5537 9.68175 19 9.68175C21.4463 9.68175 23.7925 10.6534 25.5226 12.3829C25.5373 12.3998 25.5532 12.4157 25.5701 12.4304C27.2787 14.1644 28.2326 16.5036 28.2237 18.938C28.2148 21.3724 27.2439 23.7045 25.5226 25.426Z"
                            fill="white" />
                        <path
                            d="M25.1988 22.7332C24.7519 23.4371 24.0459 24.2985 23.1585 24.5123C21.6039 24.888 19.2181 24.5252 16.2494 21.7573L16.2127 21.7249C13.6024 19.3046 12.9244 17.2901 13.0885 15.6924C13.1792 14.7856 13.9349 13.9651 14.5718 13.4297C14.6725 13.3437 14.7919 13.2825 14.9205 13.251C15.049 13.2195 15.1832 13.2184 15.3122 13.248C15.4413 13.2776 15.5616 13.337 15.6636 13.4214C15.7656 13.5058 15.8464 13.6129 15.8996 13.7341L16.8604 15.8932C16.9229 16.0332 16.946 16.1875 16.9274 16.3397C16.9087 16.4918 16.849 16.636 16.7546 16.7568L16.2688 17.3873C16.1646 17.5175 16.1017 17.6759 16.0882 17.8421C16.0748 18.0083 16.1113 18.1748 16.1933 18.32C16.4653 18.7972 17.1174 19.4989 17.8406 20.1488C18.6525 20.8829 19.5528 21.5543 20.1228 21.7832C20.2753 21.8455 20.443 21.8607 20.6043 21.8268C20.7655 21.793 20.9129 21.7116 21.0275 21.5932L21.591 21.0254C21.6997 20.9181 21.8349 20.8417 21.9829 20.8037C22.1308 20.7658 22.2861 20.7678 22.433 20.8094L24.7152 21.4572C24.8411 21.4958 24.9565 21.5627 25.0525 21.6527C25.1486 21.7428 25.2228 21.8536 25.2695 21.9767C25.3162 22.0999 25.3341 22.232 25.3218 22.3632C25.3096 22.4943 25.2675 22.6208 25.1988 22.7332Z"
                            fill="white" />
                    </svg>
                </a>
                <a href="https://www.instagram.com/varch_lighting?igsh=MXYzMGdidHJidjd5Ng==">
                    <svg class="w-10" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M37.9963 19.1112C37.9963 8.6799 29.54 0.223633 19.1087 0.223633C8.67733 0.223633 0.221069 8.6799 0.221069 19.1112C0.221069 29.5426 8.67733 37.9988 19.1087 37.9988C29.54 37.9988 37.9963 29.5426 37.9963 19.1112Z"
                            fill="url(#paint0_linear_101_6889)" />
                        <path opacity="0.1"
                            d="M33.3241 6.68634C30.5705 11.7413 26.6762 16.9552 21.8101 21.8213C16.9441 26.6873 11.7301 30.5742 6.68267 33.3278C6.36622 33.0528 6.05889 32.7661 5.76066 32.4679C3.95803 30.7255 2.52034 28.6416 1.53142 26.3377C0.542501 24.0339 0.0221442 21.5562 0.000691527 19.0492C-0.0207612 16.5422 0.45712 14.056 1.40647 11.7356C2.35582 9.41515 3.75764 7.30696 5.53018 5.53391C7.30273 3.76087 9.41054 2.35846 11.7307 1.40847C14.0508 0.458469 16.5369 -0.0201057 19.0439 0.000647142C21.551 0.0214 24.0288 0.541065 26.3329 1.52934C28.637 2.51762 30.7213 3.95473 32.4642 5.75687C32.7625 6.0551 33.0491 6.36492 33.3241 6.68634Z"
                            fill="white" />
                        <path
                            d="M23.5821 9.17188H14.6354C13.1853 9.17188 11.7946 9.74791 10.7693 10.7733C9.74394 11.7986 9.16791 13.1893 9.16791 14.6393V23.5861C9.16791 25.0362 9.74394 26.4268 10.7693 27.4522C11.7946 28.4775 13.1853 29.0536 14.6354 29.0536H23.5821C25.0322 29.0536 26.4229 28.4775 27.4482 27.4522C28.4736 26.4268 29.0496 25.0362 29.0496 23.5861V14.6393C29.0496 13.1893 28.4736 11.7986 27.4482 10.7733C26.4229 9.74791 25.0322 9.17188 23.5821 9.17188ZM27.3099 22.8008C27.3099 23.9977 26.8345 25.1457 25.9881 25.992C25.1417 26.8384 23.9938 27.3139 22.7968 27.3139H15.4207C14.2237 27.3139 13.0758 26.8384 12.2294 25.992C11.383 25.1457 10.9076 23.9977 10.9076 22.8008V15.4247C10.9076 14.2277 11.383 13.0798 12.2294 12.2334C13.0758 11.387 14.2237 10.9115 15.4207 10.9115H22.7968C23.9938 10.9115 25.1417 11.387 25.9881 12.2334C26.8345 13.0798 27.3099 14.2277 27.3099 15.4247V22.8008Z"
                            fill="white" />
                        <path
                            d="M22.7346 15.5239L22.6873 15.4767L22.6476 15.4369C21.7079 14.5005 20.4352 13.975 19.1086 13.9756C18.4387 13.9801 17.7763 14.1166 17.1591 14.3773C16.542 14.6379 15.9823 15.0176 15.5119 15.4947C15.0416 15.9717 14.6698 16.5368 14.4179 17.1575C14.166 17.7783 14.0389 18.4426 14.0438 19.1125C14.0428 20.4721 14.5787 21.777 15.5349 22.7434C16.0033 23.2175 16.5614 23.5935 17.1767 23.8495C17.792 24.1056 18.4521 24.2364 19.1186 24.2345C20.1182 24.2136 21.0902 23.9022 21.9159 23.3383C22.7416 22.7744 23.3854 21.9825 23.7687 21.059C24.1521 20.1356 24.2584 19.1205 24.0748 18.1377C23.8911 17.1548 23.4255 16.2466 22.7346 15.5239ZM19.1086 22.4825C18.4402 22.4918 17.7841 22.3022 17.2237 21.9376C16.6633 21.5731 16.2241 21.0501 15.9618 20.4352C15.6994 19.8203 15.6259 19.1413 15.7506 18.4845C15.8752 17.8277 16.1924 17.2228 16.6618 16.7468C17.1311 16.2708 17.7314 15.9451 18.3864 15.8112C19.0414 15.6773 19.7214 15.7412 20.3399 15.9948C20.9584 16.2484 21.4876 16.6803 21.86 17.2355C22.2324 17.7906 22.4313 18.444 22.4314 19.1125C22.4346 19.552 22.3513 19.9878 22.186 20.3951C22.0208 20.8024 21.7769 21.1731 21.4683 21.486C21.1597 21.799 20.7925 22.0481 20.3876 22.2191C19.9827 22.39 19.5481 22.4795 19.1086 22.4825Z"
                            fill="white" />
                        <path
                            d="M25.6772 13.7402C25.6785 13.8997 25.6484 14.0579 25.5885 14.2057C25.5286 14.3535 25.4401 14.488 25.3282 14.6016C25.2162 14.7152 25.0829 14.8055 24.936 14.8675C24.7891 14.9295 24.6314 14.962 24.4719 14.9629C24.3138 14.9629 24.1572 14.9314 24.0113 14.8704C23.8654 14.8094 23.7331 14.7201 23.6219 14.6076C23.4536 14.4367 23.3391 14.2202 23.2926 13.9849C23.2461 13.7496 23.2697 13.5059 23.3605 13.2839C23.4512 13.0619 23.6052 12.8714 23.8032 12.736C24.0012 12.6007 24.2346 12.5264 24.4744 12.5225C24.7551 12.5224 25.0268 12.6209 25.2423 12.8008L25.2672 12.8257C25.3072 12.8583 25.3439 12.8949 25.3765 12.935L25.4038 12.9648C25.5817 13.184 25.6783 13.4579 25.6772 13.7402Z"
                            fill="white" />
                        <defs>
                            <linearGradient id="paint0_linear_101_6889" x1="5.75315" y1="5.75571" x2="32.4642"
                                y2="32.4667" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#FAE100" />
                                <stop offset="0.15" stop-color="#FCB720" />
                                <stop offset="0.3" stop-color="#FF7950" />
                                <stop offset="0.5" stop-color="#FF1C74" />
                                <stop offset="1" stop-color="#6C1CD1" />
                            </linearGradient>
                        </defs>
                    </svg>

                </a>
            </div>
        </div>
    </div>
    <div class="w-[15%] pt-16" data-aos="fade-left" data-aos-duration="1400">
        <h1 class="text-[16px] xl:text-[20px] font-bold">V-Arch Lighting</h1>
        <div class="text-[12px] flex flex-col gap-2 pt-4">
            <p>
                Our Factory is located in Kompong Cham Province
            </p>
            <p>
                Office Address: #7D, ST.70, Sangkat Srah Chork, Khan Daun Penh, Phnom Penh
            </p>
            <p>
                (+855) 87 68 67 68
            </p>
            <a href="#" class="underline">info@v-archlighting.com</a>
            {{-- <a href="#" class="hover:underline">www.lehsekmeasrice.com</a> --}}
        </div>
    </div>
    <div class="w-[15%] pt-16" data-aos="fade-left" data-aos-duration="1400">
        <h1 class="text-[16px] xl:text-[20px] font-bold">{{ app()->getLocale() === 'en' ? 'Working Time' : (app()->getLocale() === 'km' ? 'ម៉ោងធ្វើការ' : 'Working Time') }}</h1>
        <div class="text-[12px] flex flex-col gap-2 pt-4">
            <p>
                {{ app()->getLocale() === 'en' ? 'Monday- Sunday' : (app()->getLocale() === 'km' ? 'ច័ន្ទ – អាទិត្យ' : 'Monday- Sunday') }}
            </p>
            <p>
                {{ app()->getLocale() === 'en' ? '8AM - 5PM' : (app()->getLocale() === 'km' ? '៨ព្រឹក – ៥ល្ងាច' : '8AM - 5PM') }}
            </p>
        </div>
        <h1 class="text-[16px] xl:text-[20px] font-bold pt-4">{{ app()->getLocale() === 'en' ? 'Map' : (app()->getLocale() === 'km' ? 'ទីតាំង' : 'Map') }}</h1>
        <div class="pt-2">
            <iframe class="w-[95%] h-[200px]"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3741.4436291086704!2d104.920699!3d11.5212099!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x310950bf57e61dff%3A0x1cd908096238297a!2sV-Arch%20Lighting!5e1!3m2!1sen!2skh!4v1766195511008!5m2!1sen!2skh"
                style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</footer>


<footer class="flex flex-col gap-6 lg:hidden px-6 pb-6 overflow-hidden">
    <div data-aos="fade-right" data-aos-duration="1400">
        <img src="{{ asset('assets/images/lamp-2.png') }}" alt="" class="w-[15rem] mx-auto">
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 items-start gap-6" data-aos="fade-right" data-aos-duration="1400">
        <div class="">
            <h1 class="text-[16px] xl:text-[20px] font-bold">V-Arch Lighting</h1>
            <p class="text-[12px] pt-4">
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut
                laoreet
                dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper
                suscipit lobortis nisl ut aliquip ex ea commodo consequat.
            </p>
        </div>
        <div class="" data-aos="fade-right" data-aos-duration="1400">
            <h1 class="text-[16px] xl:text-[20px] font-bold">V-Arch Lighting</h1>
            <div class="text-[12px] flex flex-col gap-2 pt-4">
                <p>
                    Our Factory is located in Kompong Cham Province
                </p>
                <p>
                    Office Address: #7D, ST.70, Sangkat Srah Chork, Khan Daun Penh, Phnom Penh
                </p>
                <p>
                    855 (0) 87 68 67 68
                </p>
                <a href="#" class="underline">info@v-archlighting.com</a>
                {{-- <a href="#" class="hover:underline">www.lehsekmeasrice.com</a> --}}
            </div>
        </div>
        <div class="" data-aos="fade-right" data-aos-duration="1400">
            <h1 class="text-[16px] xl:text-[20px] font-bold">{{ app()->getLocale() === 'en' ? 'Information' : (app()->getLocale() === 'km' ? 'ព័ត៌មាន' : 'Information') }}</h1>
            <ul class="text-[12px] xl:text-[14px] pt-4 space-y-1">
                <li class="py-1"><a class="hover:underline transition-all duration-300"
                        href="{{ route('home') }}">{{ app()->getLocale() === 'en' ? 'Home' : (app()->getLocale() === 'km' ? 'ទំព័រដើម' : 'Home') }}</a>
                </li>
                <li class="py-1"><a class="hover:underline transition-all duration-300"
                        href="{{ route('about') }}">{{ app()->getLocale() === 'en' ? 'About Us' : (app()->getLocale() === 'km' ? 'អំពីយើងខ្ញុំ' : 'About Us') }}</a>
                </li>
                <li class="py-1"><a class="hover:underline transition-all duration-300"
                        href="{{ route('product') }}">{{ app()->getLocale() === 'en' ? 'Our Products' : (app()->getLocale() === 'km' ? 'ផលិតផលរបស់យើងខ្ញុំ' : 'Our Products') }}</a>
                </li>
                <li class="py-1"><a class="hover:underline transition-all duration-300"
                        href="{{ route('project') }}">{{ app()->getLocale() === 'en' ? 'Our Projects' : (app()->getLocale() === 'km' ? 'គម្រោងរបស់យើងខ្ញុំ' : 'Our Projects') }}</a>
                </li>
                <li class="py-1"><a class="hover:underline transition-all duration-300"
                        href="{{ route('store') }}">{{ app()->getLocale() === 'en' ? 'Store Location' : (app()->getLocale() === 'km' ? 'ទីតាំងហាង' : 'Store Location') }}</a>
                </li>
                <li class="py-1"><a class="hover:underline transition-all duration-300"
                        href="{{ route('contact') }}">{{ app()->getLocale() === 'en' ? 'Contact Us' : (app()->getLocale() === 'km' ? 'ទំនាក់ទំនងមកយើង' : 'Contact Us') }}</a>
                </li>
            </ul>
        </div>
        <div class="" data-aos="fade-right" data-aos-duration="1400">
            <h1 class="text-[16px] xl:text-[20px] font-bold">
                {{ app()->getLocale() === 'en' ? 'Working Time' : (app()->getLocale() === 'km' ? 'ម៉ោងធ្វើការ' : 'Working Time') }}
            </h1>
            <div class="text-[12px] flex flex-col gap-2 pt-4">
                <p>
                    {{ app()->getLocale() === 'en' ? 'Monday- Sunday' : (app()->getLocale() === 'km' ? 'ច័ន្ទ – អាទិត្យ' : 'Monday- Sunday') }}
                </p>
                <p>
                    {{ app()->getLocale() === 'en' ? '8AM - 5PM' : (app()->getLocale() === 'km' ? '៨ព្រឹក – ៥ល្ងាច' : '8AM - 5PM') }}
                </p>
            </div>
            <h1 class="text-[16px] xl:text-[20px] font-bold pt-4">{{ app()->getLocale() === 'en' ? 'Map' : (app()->getLocale() === 'km' ? 'ទីតាំង' : 'Map') }}</h1>
            <div class="pt-2">
                <iframe class="w-full sm:h-[70%] h-[200px]"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3741.4436291086704!2d104.920699!3d11.5212099!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x310950bf57e61dff%3A0x1cd908096238297a!2sV-Arch%20Lighting!5e1!3m2!1sen!2skh!4v1766195511008!5m2!1sen!2skh"
                    style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>

    <div class="flex flex-col gap-4 items-center text-center">
        <h1>Follow Us</h1>
        <div class="flex items-center gap-4">
            <a href="https://www.facebook.com/varch.lighting.52">
                <img src="{{ asset('assets/images/icons/fb.png') }}" alt="" class="w-10">
            </a>
            <a href="https://t.me/limvandara_lighting">
                <img src="{{ asset('assets/images/icons/telegram.png') }}" alt="" class="w-10">
            </a>
            <a href="#">
                <img src="{{ asset('assets/images/icons/whatapp.png') }}" alt="" class="w-10">
            </a>
            <a href="https://www.instagram.com/varch_lighting?igsh=MXYzMGdidHJidjd5Ng==">
                <img src="{{ asset('assets/images/icons/ig.png') }}" alt="" class="w-10">
            </a>
        </div>
    </div>
</footer>
