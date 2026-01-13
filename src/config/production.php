<?php
return [
    'settings' => [
        'displayErrorDetails' => false, // Set to false in production
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Level::Debug,
        ],
    ],
];