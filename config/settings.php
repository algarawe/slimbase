<?php

// Should be set to 0 in production
//error_reporting(E_ALL);
// Should be set to '0' in production
//ini_set('display_errors', '1');

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
