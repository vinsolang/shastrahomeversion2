<?php

declare(strict_types=1);

$shared = require __DIR__ . '/shared.php';

return [
    'view' => 'frontend.projects',
    'eyebrow' => 'Projects',
    'title' => 'Projects',
    'description' => 'Explore a portfolio of residential work with expandable project details, image galleries, and category filters.',
    'portfolio' => $shared['portfolio'],
];
