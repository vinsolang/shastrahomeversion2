<?php

declare(strict_types=1);

$navigation = [
    ['label' => 'Home', 'route' => 'home'],
    ['label' => 'Services', 'route' => 'services'],
    ['label' => 'About Us', 'route' => 'about'],
    ['label' => 'Projects', 'route' => 'projects'],
    ['label' => 'Templates', 'route' => 'templates'],
    ['label' => 'Contact us', 'route' => 'contact'],
];

$contact = [
    'address_lines' => [
        'Phnom, Building 184, Samdach Chakrei Ponn St. (208),',
        'Phnom Penh វិថី សម្តេចចក្រីប៉ុន (២០៨), រាជធានី​ភ្នំពេញ, Penh 12211',
    ],
    'phones' => [
        '+855 98 660 266',
        '+855 60 660 266',
    ],
    'hours' => 'Mon-Fri from 8am to 5pm',
    'email' => 'info@shastraconstruction.com',
    'socials' => [
        ['label' => 'Facebook', 'icon' => 'facebook', 'href' => 'https://www.facebook.com/Shastra/'],
        ['label' => 'TikTok', 'icon' => 'tiktok', 'href' => 'https://www.tiktok.com/@shastrahome?is_from_webapp=1&sender_device=pc'],
        // ['label' => 'Instagram', 'icon' => 'instagram', 'href' => null],
        ['label' => 'Telegram', 'icon' => 'telegram', 'href' => 'https://t.me/Shastrahome'],
    ],
];

$footerLogoPlaceholders = array_map(
    static fn (string $label): array => ['label' => $label],
    [
        'Studio partner',
        'Project partner',
        'Construction partner',
        'Design partner',
        'Supplier partner',
        'Client partner',
    ],
);

$pages = require __DIR__ . '/site/pages.php';

return [
    // Brand
    'brand' => [
        'name' => 'Shastra Home',
        'location' => '',
    ],

    // Nav
    'navigation' => $navigation,

    // Hero
    'hero' => [
        'eyebrow' => 'MASTERPIECE OF ARCHITECTURE',
        'title' => 'Shastra Home',
        'titleAccent' => '.',
        'description' => 'Delivering thoughtful design and quality construction for modern living.',
        'primaryCta' => [
            'label' => 'Contact Us',
            'route' => 'contact',
        ],
        'secondaryCta' => [
            'label' => 'Get Quote',
            'route' => 'contact',
        ],
        'videos' => [
            [
                'label' => 'Hero video footage',
                'src' => 'assets/videos/Main-video.mp4',
            ],
        ],
    ],

    // Stats
    'stats' => [
        ['value' => '143+', 'label' => 'Projects Deliverable'],
        ['value' => '28+', 'label' => 'Clients'],
        ['value' => '31+', 'label' => 'Partners'],
    ],

    // Contact
    'contact' => $contact,

    // Footer
    'footer' => [
        'cta' => [
            'headline' => 'Start Your Dream Project Today',
            'emphasis' => 'Dream Project',
            'accent' => '.',
            'button_label' => 'Contact us',
            'button_route' => 'contact',
            'background_image' => 'assets/images/Footer/Footer-bg-1.png',
        ],
        'team' => [
            'eyebrow' => 'OUR TEAM',
            'caption' => 'The people behind',
            'image' => 'assets/images/Footer/Teams.png',
            'message' => [
                'We are ready to turn your vision into reality.',
                'Reach out for a consultation.',
            ],
        ],
        'logo_strip' => [
            'items' => $footerLogoPlaceholders,
        ],
        'description_heading' => 'Shastra Home',
        'description' => [
            'Shastra Home offers professional design and construction services for a wide range of building projects, supported by years of experience and a dedicated team of skilled professionals.',
            'We take pride in earning the trust of our clients through quality craftsmanship, reliability, and attention to detail.',
        ],
        'company_links' => [
            ['label' => 'Home', 'route' => 'home'],
            ['label' => 'Projects', 'route' => 'projects'],
            ['label' => 'Services', 'route' => 'services'],
            ['label' => 'Templates', 'route' => 'templates'],
            ['label' => 'About Us', 'route' => 'about'],
            ['label' => 'Contact', 'route' => 'contact'],
        ],
        'contact' => $contact,
        'legal' => [
            'copyright' => 'Copyright 2023 Shastra Home. All rights reserved.',
            'links' => [
                ['label' => 'Privacy Policy', 'href' => null],
                ['label' => 'Term of Service', 'href' => null],
            ],
        ],
    ],

    // Pages
    'pages' => $pages,
];
