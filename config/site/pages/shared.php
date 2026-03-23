<?php

declare(strict_types=1);

// Gallery
$buildProjectGallery = static function (int $projectNumber, int $imageCount): array {
    return array_map(
        static fn (int $imageIndex): string => sprintf(
            'assets/images/Projects/home (%d)/Shastra Home %02d_View %02d.jpg',
            $projectNumber,
            $projectNumber,
            $imageIndex,
        ),
        range(1, $imageCount),
    );
};

// Project
$buildPortfolioProject = static function (int $projectNumber, int $imageCount, array $attributes) use ($buildProjectGallery): array {
    $gallery = $buildProjectGallery($projectNumber, $imageCount);

    return array_merge($attributes, [
        'id' => sprintf('project-%d', $projectNumber),
        'cover_image' => $gallery[0],
        'gallery' => $gallery,
    ]);
};

// Shared
return [
    'difference' => [
        'eyebrow' => 'The Difference',
        'title' => 'Why Choose Us?',
        'paragraphs' => [
            'SHASTRA Home is guided by responsibility and thoughtful design. With over a decade of experience in architecture and construction, we build homes that deliver comfort, performance, and long-term value. Our projects follow a clear process from structured planning and layout designs to construction, ensuring practical living spaces with good ventilation, natural lighting, and efficient layouts.',
            'We work with clear communication and respect for agreed budgets and timelines. Our commitment is to take responsibility for construction and well-thought designs, creating homes that support everyday living and remain functional over time.',
        ],
        'image' => 'assets/images/Services/Services-img.png',
    ],
    'media' => [
        'headline_prefix' => 'Delivering thoughtful',
        'headline_emphasis' => 'design & quality',
        'headline_suffix' => 'construction for modern living',
        'accent' => '.',
        'video' => 'assets/videos/Main-video.mp4',
    ],
    'portfolio' => [
        'heading' => [
            'eyebrow' => 'OUR',
            'title' => 'PORTFOLIO',
        ],
        'tabs' => [
            'Renovation',
            'Construction',
            'Architectural design',
            'Interior',
        ],
        'projects' => [
            $buildPortfolioProject(1, 6, [
                'type_label' => 'Residential',
                'title' => 'Villa Prey Veng',
                'specification' => '2,400 sq ft, 4 Bed, 3 Bath',
                'location' => 'Prey Veng Province',
                'concept' => 'This residential concept focuses on a bright, open frontage with a modern facade and practical family-first planning.',
                'categories' => ['Renovation', 'Construction'],
            ]),
            $buildPortfolioProject(2, 5, [
                'type_label' => 'Residential',
                'title' => 'Garden Court House',
                'specification' => '2,180 sq ft, 3 Bed, 3 Bath',
                'location' => 'Kandal Province',
                'concept' => 'A calm home arranged around soft landscaping, clear circulation, and a welcoming front elevation for suburban living.',
                'categories' => ['Renovation', 'Architectural design'],
            ]),
            $buildPortfolioProject(3, 5, [
                'type_label' => 'Residential',
                'title' => 'Palm View Residence',
                'specification' => '2,060 sq ft, 3 Bed, 2 Bath',
                'location' => 'Takeo Province',
                'concept' => 'This scheme balances elegant proportions with breezy living spaces and warm finishes suited for everyday comfort.',
                'categories' => ['Renovation', 'Interior'],
            ]),
            $buildPortfolioProject(4, 5, [
                'type_label' => 'Residential',
                'title' => 'Courtyard Villa',
                'specification' => '2,520 sq ft, 4 Bed, 3 Bath',
                'location' => 'Kampong Speu',
                'concept' => 'A low-rise villa designed with stronger street presence, shaded outdoor transitions, and straightforward construction detailing.',
                'categories' => ['Renovation', 'Construction', 'Architectural design'],
            ]),
            $buildPortfolioProject(5, 5, [
                'type_label' => 'Residential',
                'title' => 'Modern Family Home',
                'specification' => '2,280 sq ft, 4 Bed, 3 Bath',
                'location' => 'Siem Reap',
                'concept' => 'A practical family home shaped by efficient room planning, clean lines, and a restrained material palette.',
                'categories' => ['Renovation', 'Construction', 'Interior'],
            ]),
            $buildPortfolioProject(6, 5, [
                'type_label' => 'Residential',
                'title' => 'Skyline Pavilion',
                'specification' => '2,340 sq ft, 4 Bed, 3 Bath',
                'location' => 'Phnom Penh',
                'concept' => 'This featured placeholder project stands in for the expanded portfolio state, showing a fuller story and the complete image set.',
                'categories' => ['Renovation', 'Architectural design', 'Interior'],
            ]),
        ],
    ],
];
