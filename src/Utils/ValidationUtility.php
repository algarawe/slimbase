<?php
// src/Utils/ValidationUtility.php
namespace App\Utils;

final class ValidationUtility
{
    // Utility methods can be static or non-static, depending on your needs.
    // A private constructor can prevent instantiation if all methods are static.
    private function __construct() {}

    public static function formatMessage(string $message): string
    {
        return "Formatted: " . $message;
    }

    public function someInstanceMethod()
    {
        // ...
    }
}
