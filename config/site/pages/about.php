<?php

declare(strict_types=1);

$shared = require __DIR__ . '/shared.php';

return [
    'view' => 'frontend.about',
    'eyebrow' => 'About Us',
    'title' => 'About Us',
    'description' => 'Shastra Home is an architecture and construction company dedicated to creating high-quality, sustainable living environments built for modern everyday life.',
    'story' => [
        'background_image' => 'assets/images/About us/About-hero-house.png',
        'background_video' => 'assets/videos/Main-video.mp4',
        'title' => 'About Us',
        'paragraphs' => [
            'Shastra Home is an architecture and construction company dedicated to creating high-quality, sustainable living environments in suburban and provincial areas. We focus on building homes with exceptional quality, incorporating designs that maximize natural light, promote proper ventilation, and integrate greenery to create comfortable, healthy, and adaptable living spaces for everyday life.',
            'With over a decade of experience in design and construction, we have built trust and set high standards of quality, consistently meeting the dreams and expectations of our clients with professionalism and meticulous attention at every stage of the project.',
        ],
        'download_cta' => [
            'label' => 'Download Company Profile',
            'icon' => 'assets/images/About us/Download-logo.svg',
            'href' => null,
            'available' => false,
        ],
    ],
    'philosophy' => [
        'eyebrow' => 'OUR PHILOSOPHY',
        'mission' => [
            'title' => 'Mission',
            'description' => 'At Shastra Home, our mission is to create homes that combine quality craftsmanship with thoughtful design. We focus on using resources efficiently and embracing natural elements to build living spaces that are comfortable, adaptable, and built to last. Every project is carried out with honesty, care, and professionalism with the goal of improving the way people live every day.',
        ],
        'vision' => [
            'title' => 'Vision',
            'description' => 'Our vision is to provide homeowners with better, adaptable living environments for everyday life. We believe that thoughtful and careful design can enhance daily living, and we take pride in contributing to sustainable and future-ready communities.',
        ],
    ],
    'core_values' => [
        'title' => 'Core Values',
        'intro' => 'The fundamental principles that guide our work, our relationships, and our commitment to excellence in every project we undertake.',
        'background_image' => 'assets/images/About us/Logo-BG 1.png',
        'items' => [
            [
                'icon' => 'assets/images/About us/Icon 1.svg',
                'title' => 'Reliability',
                'description' => 'Consistent performance you can count on.',
            ],
            [
                'icon' => 'assets/images/About us/Icon 2.svg',
                'title' => 'Quality & Assurance',
                'description' => 'Rigorous testing and premium materials.',
            ],
            [
                'icon' => 'assets/images/About us/Icon 3.svg',
                'title' => 'Elevated Standards',
                'description' => 'Setting new benchmarks in construction.',
            ],
            [
                'icon' => 'assets/images/About us/Icon 4.svg',
                'title' => 'Long-term Value',
                'description' => 'Investments that stand the test of time.',
            ],
        ],
    ],
    'founder' => [
        'image' => 'assets/images/About us/Founder.png',
        'image_alt' => 'SHASTRA Home CEO portrait',
        'name' => '',
        'role' => 'Chief Executive Officer',
        'statements' => [
            [
                'lang' => 'en',
                'text' => 'Modern Cambodian living begins with the willingness to think differently, embrace changes, and raise living standards through quality and responsibility.',
            ],
            [
                'lang' => 'en',
                'text' => 'At SHASTRA Home, we believe progress comes from well defined strategic planning, responsibility and disciplined executions. We focus on building homes that support everyday living and remain reliable for the future.',
            ],
            [
                'lang' => 'km',
                'text' => 'ការរស់នៅខ្មែរសម័យថ្មី ចាប់ផ្តើមពីគំនិត ចង់ផ្លាស់ប្តូរ និងលើកកម្ពស់បទដ្ឋាននៃការរស់នៅ ដោយផ្អែកលើគុណភាព និងទំនួលខុសត្រូវ។',
            ],
            [
                'lang' => 'km',
                'text' => 'នៅ លំនៅឋាន ​សាស្រ្ដា​ យើងជឿជាក់ថា ការរីកចម្រើនកើតចេញពីការរៀបចំផែនការច្បាស់លាស់ ការសាងសង់ដោយទំនួលខុសត្រូវ ផ្អែកលើបទពិសោធន៍ អនុវត្តដោយវិន័យ ដើម្បីបង្កើតផ្ទះដ៏កក់ក្ដៅ ​សម្រាប់ការប្រើប្រាស់ប្រចាំថ្ងៃ និងធានាគុណភាពសម្រាប់អនាគត។',
            ],
        ],
    ],
    'difference' => $shared['difference'],
    'media' => $shared['media'],
];
