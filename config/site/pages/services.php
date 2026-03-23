<?php

declare(strict_types=1);

$shared = require __DIR__ . '/shared.php';

return [
    'view' => 'frontend.services',
    'eyebrow' => 'Services',
    'title' => 'Services',
    'description' => 'Architectural design, residential construction, MEP systems, and finishing works tailored for thoughtful modern homes.',
    'cards' => [
        [
            'icon' => 'assets/images/Services/Services-logo-1.svg',
            'icon_tone' => 'dark-source',
            'title' => 'Architectural Design and Master planning services',
            'description' => 'We provide comprehensive architectural design and master planning services that transform ideas into functional, aesthetic, and sustainable spaces.',
            'theme' => 'dark',
            'cta_label' => 'Read More',
        ],
        [
            'icon' => 'assets/images/Services/Services-logo-2.svg',
            'icon_tone' => 'accent-source',
            'title' => 'Construction of Residential Properties',
            'description' => 'We specialize in the construction of high-quality residential properties, including villas, townhouses, housing developments, and resorts.',
            'theme' => 'dark',
            'cta_label' => 'Read More',
        ],
        [
            'icon' => 'assets/images/Services/Services-logo-3.svg',
            'icon_tone' => 'accent-source',
            'title' => 'Design, engineering, and execution of (MEP) systems',
            'description' => 'Our MEP services cover the complete design, coordination, and execution of mechanical, electrical, and plumbing systems.',
            'theme' => 'dark',
            'cta_label' => 'Read More',
        ],
        [
            'icon' => 'assets/images/Services/Services-logo-4.svg',
            'icon_tone' => 'accent-source',
            'title' => 'Comprehensive interior and exterior design and finishing works',
            'description' => 'We offer complete interior and exterior design and decoration services that enhance both aesthetics and functionality.',
            'theme' => 'dark',
            'cta_label' => 'Read More',
        ],
    ],
    'difference' => $shared['difference'],
    'media' => $shared['media'],
];
