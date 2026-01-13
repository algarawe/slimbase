<?php

namespace SlimBase\Monitoring;

class Metrics
{
    private static array $data = [];

    public static function record(string $key, float $value): void
    {
        self::$data[$key][] = $value;
    }

    public static function getAll(): array
    {
        return self::$data;
    }
}
