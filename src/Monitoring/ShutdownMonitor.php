<?php

namespace SlimBase\Monitoring;

use Throwable;
use Psr\Log\LoggerInterface; // Using the standard PSR-3 Logger Interface

class ShutdownMonitor
{
	private static LoggerInterface $logger;
	
	public static function init(LoggerInterface $logger): void
    {
        self::$logger = $logger;

        register_shutdown_function([self::class, 'handle']);
    }
	
     

	public static function handle(): void
    {
        $totalMs = (hrtime(true) - APP_START_TIME) / 1e6;

        self::$logger->info('application.metrics', [
            'total_ms' => $totalMs,
            'metrics'  => Metrics::getAll(),
            'memory'   => memory_get_peak_usage(true),
            'timestamp'=> time()
        ]);
    }
	
    
 
}
