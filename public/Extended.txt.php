<?php
define('APP_START_TIME', hrtime(true));
define('APP_ROOT_DIR', __DIR__);

// Detect environment
$environment = getenv('APP_ENV') ?: $_SERVER['APP_ENV'] ?? 'production';

// Configuration array
$config = [
    'production' => [
        'display_errors' => false,
        'log_errors' => true,
        'debug' => false
    ],
    'development' => [
        'display_errors' => true,
        'log_errors' => true,
        'debug' => true
    ],
    'staging' => [
        'display_errors' => false,
        'log_errors' => true,
        'debug' => false
    ]
];

// Get config for current environment
$currentConfig = $config[$environment] ?? $config['production'];

// Use in error middleware
$app->addErrorMiddleware(
    $currentConfig['display_errors'],
    $currentConfig['log_errors'],
    $currentConfig['log_errors'], // or separate setting for logErrorDetails
    $container->get(LoggerInterface::class)
);