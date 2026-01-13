<?php

namespace SlimBase\Middleware;

use SlimBase\Monitoring\Metrics;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TimingMiddleware
{
    public function __invoke(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $start = hrtime(true);

        $response = $handler->handle($request);

        $durationMs = (hrtime(true) - $start) / 1e6;

        $route = $request->getUri()->getPath();
        Metrics::record("route.$route", $durationMs);

        return $response;
    }
}
