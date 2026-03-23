<?php

declare(strict_types=1);

$defaults = [
    // Defaults
    'services' => [
        'eyebrow' => 'Services',
        'title' => 'Services',
        'description' => 'This page is prepared for the final services content and can be filled in next without changing the main layout structure.',
    ],
    'about' => [
        'eyebrow' => 'About Us',
        'title' => 'About Us',
        'description' => 'This page is prepared for the final company story, positioning, and team content that will be added in the next phase.',
    ],
    'projects' => [
        'eyebrow' => 'Projects',
        'title' => 'Projects',
        'description' => 'This page is prepared for featured work, project galleries, and future case study content using a clean standalone route.',
    ],
    'templates' => [
        'eyebrow' => 'Templates',
        'title' => 'Templates',
        'description' => 'This page is prepared for the final templates showcase and can be expanded once the actual content direction is confirmed.',
    ],
    'contact' => [
        'eyebrow' => 'Contact',
        'title' => 'Contact us',
        'description' => 'This page is prepared for your final contact experience, inquiry details, and any lead form or CTA block you want to add next.',
    ],
];

// Loader
$loadPage = static function (string $slug) use ($defaults): array {
    $default = $defaults[$slug] ?? [];
    $path = __DIR__ . "/pages/{$slug}.php";

    if (! file_exists($path)) {
        return $default;
    }

    $page = require $path;

    if (! is_array($page)) {
        return $default;
    }

    return array_replace_recursive($default, $page);
};

// Pages
return [
    'services' => $loadPage('services'),
    'about' => $loadPage('about'),
    'projects' => $loadPage('projects'),
    'templates' => $loadPage('templates'),
    'contact' => $loadPage('contact'),
];
