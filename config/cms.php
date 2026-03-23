<?php

declare(strict_types=1);

return [
    'global_sections' => [
        [
            'key' => 'brand',
            'label' => 'Brand',
            'type' => 'json',
            'help' => 'Brand identity settings such as name and location.',
        ],
        [
            'key' => 'navigation',
            'label' => 'Navigation',
            'type' => 'json',
            'help' => 'Primary navigation links for the marketing site.',
        ],
        [
            'key' => 'contact',
            'label' => 'Contact',
            'type' => 'json',
            'help' => 'Shared contact details and social links.',
        ],
        [
            'key' => 'footer',
            'label' => 'Footer',
            'type' => 'json',
            'help' => 'Footer CTA, team, legal copy, and shared footer content.',
        ],
    ],
    'editable_pages' => [
        'home' => [
            'label' => 'Home',
            'route' => 'home',
            'sections' => [
                [
                    'key' => 'hero',
                    'label' => 'Hero',
                    'type' => 'json',
                    'help' => 'Hero copy, CTA, and media settings.',
                ],
                [
                    'key' => 'stats',
                    'label' => 'Stats',
                    'type' => 'json',
                    'help' => 'Homepage KPI repeater items.',
                ],
            ],
        ],
        'about' => [
            'label' => 'About',
            'route' => 'about',
            'sections' => [
                [
                    'key' => 'title',
                    'label' => 'Title',
                    'type' => 'text',
                    'help' => 'Page title shown in the About view.',
                ],
                [
                    'key' => 'description',
                    'label' => 'Description',
                    'type' => 'textarea',
                    'help' => 'Meta description and supporting page summary.',
                ],
                [
                    'key' => 'story',
                    'label' => 'Story',
                    'type' => 'json',
                    'help' => 'Story hero copy, media, and download CTA.',
                ],
                [
                    'key' => 'philosophy',
                    'label' => 'Philosophy',
                    'type' => 'json',
                    'help' => 'Mission and vision content.',
                ],
                [
                    'key' => 'core_values',
                    'label' => 'Core Values',
                    'type' => 'json',
                    'help' => 'Core values repeater content.',
                ],
                [
                    'key' => 'founder',
                    'label' => 'Founder',
                    'type' => 'json',
                    'help' => 'Founder profile and quote content.',
                ],
                [
                    'key' => 'difference',
                    'label' => 'Difference',
                    'type' => 'json',
                    'help' => 'Why choose us content block.',
                ],
                [
                    'key' => 'media',
                    'label' => 'Media',
                    'type' => 'json',
                    'help' => 'Closing media section content.',
                ],
            ],
        ],
        'services' => [
            'label' => 'Services',
            'route' => 'services',
            'sections' => [
                [
                    'key' => 'title',
                    'label' => 'Title',
                    'type' => 'text',
                    'help' => 'Page title shown in the Services view.',
                ],
                [
                    'key' => 'description',
                    'label' => 'Description',
                    'type' => 'textarea',
                    'help' => 'Page meta description and supporting summary.',
                ],
                [
                    'key' => 'cards',
                    'label' => 'Cards',
                    'type' => 'json',
                    'help' => 'Service card repeater content.',
                ],
                [
                    'key' => 'difference',
                    'label' => 'Difference',
                    'type' => 'json',
                    'help' => 'Why choose us section content.',
                ],
                [
                    'key' => 'media',
                    'label' => 'Media',
                    'type' => 'json',
                    'help' => 'Supporting media section content.',
                ],
            ],
        ],
        'contact' => [
            'label' => 'Contact',
            'route' => 'contact',
            'sections' => [
                [
                    'key' => 'title',
                    'label' => 'Title',
                    'type' => 'text',
                    'help' => 'Page title shown in the Contact view.',
                ],
                [
                    'key' => 'description',
                    'label' => 'Description',
                    'type' => 'textarea',
                    'help' => 'Page meta description and supporting summary.',
                ],
                [
                    'key' => 'hero',
                    'label' => 'Hero',
                    'type' => 'json',
                    'help' => 'Contact hero content and supporting media.',
                ],
                [
                    'key' => 'form',
                    'label' => 'Form',
                    'type' => 'json',
                    'help' => 'Contact form labels, placeholders, and options.',
                ],
                [
                    'key' => 'media',
                    'label' => 'Media',
                    'type' => 'json',
                    'help' => 'Closing media section content.',
                ],
            ],
        ],
    ],
];
