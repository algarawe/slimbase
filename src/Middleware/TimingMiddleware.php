<?php
namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface; // Using the standard PSR-3 Logger Interface

class TimingMiddleware implements MiddlewareInterface
{
    private ?LoggerInterface $logger;

    public function __construct(?LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $start = microtime(true);
        $response = $handler->handle($request);
        $duration = microtime(true) - $start;

        // Add timing header
        $response = $response->withHeader('X-Duration-ms', (string) round($duration * 1000, 3));

        // Optionally log
        if ($this->logger) {
            $this->logger->info('Request duration', ['duration_ms' => round($duration * 1000, 3)]);
        }

        return $response;
    }

    private function log($request, $response, float $timeMs): void
    {
        $data = [
            'method' => $request->getMethod(),
            'uri'    => (string)$request->getUri(),
            'status' => $response?->getStatusCode(),
            'timeMs' => round($timeMs, 2),
            'ip'     => $request->getServerParams()['REMOTE_ADDR'] ?? 'unknown'
        ];

        error_log(json_encode($data, JSON_UNESCAPED_SLASHES));
    }
}
