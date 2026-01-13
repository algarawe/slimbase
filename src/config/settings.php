<?php

return array(
	'loggerparam' => [
        'displayErrorDetails' => true, // Set to false in production
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Level::Debug,
        ],
    ],
    'server' => 'localhost',    
    'jwtKey' => '12345',    
    'tokenValidity' => 1800, //In seconds
	'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Level::Debug,
			'path' => __DIR__ . '/../logs/app.log',
        ],
		
    ],
    'db' => array(
        'host' => '',
        'user' => '',
        'pass' => '',
        'dbname' => ''
    )
);