<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // Set to false in production
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Level::Debug,
        ],
    ],
];