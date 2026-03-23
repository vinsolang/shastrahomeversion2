<?php

declare(strict_types=1);

$shared = require __DIR__ . '/shared.php';

return [
    'view' => 'frontend.contact',
    'eyebrow' => 'Contact',
    'title' => 'Contact us',
    'description' => 'Ready to start your project? Contact our team today for a free consultation and quote. We are here to answer any questions you may have about our services.',
    'hero' => [
        'eyebrow' => 'Get in Touch',
        'headline' => "Let's Build Vision",
        'accent' => '.',
        'description' => 'Ready to start your project? Contact our team today for a free consultation and quote. We are here to answer any questions you may have about our services.',
        'video' => 'assets/videos/Main-video.mp4',
        'poster' => 'assets/images/Contact/contact-hero-poster.jpg',
    ],
    'form' => [
        'title' => 'Get a Quote',
        'fields' => [
            'first_name' => [
                'label' => 'First Name',
                'placeholder' => 'First Name',
                'type' => 'text',
                'autocomplete' => 'given-name',
            ],
            'last_name' => [
                'label' => 'Last Name',
                'placeholder' => 'Last Name',
                'type' => 'text',
                'autocomplete' => 'family-name',
            ],
            'email_address' => [
                'label' => 'Email Address',
                'placeholder' => 'Email Address',
                'type' => 'email',
                'autocomplete' => 'email',
            ],
            'project_type' => [
                'label' => 'Project Type',
                'placeholder' => 'Project Type',
                'options' => [
                    'Residential Construction',
                    'Architectural Design',
                    'Interior Design',
                    'Renovation',
                ],
            ],
            'message' => [
                'label' => 'Message',
                'placeholder' => 'Message',
                'rows' => 5,
            ],
        ],
        'submit_label' => 'Send Message',
    ],
    'media' => $shared['media'],
];
