#!/usr/bin/env php
<?php
/**
 * Load environment variables from .env file
 * This should be called before running the PHP server
 */

$envFile = __DIR__ . '/.env';

if (!file_exists($envFile)) {
    die("Error: .env file not found. Please copy .env.example to .env and configure your database credentials.\n");
}

$lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
    // Skip comments
    if (strpos(trim($line), '#') === 0) {
        continue;
    }
    
    // Parse KEY=VALUE
    if (strpos($line, '=') !== false) {
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        
        // Set environment variable
        putenv("$key=$value");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

echo "✅ Environment variables loaded from .env\n";
echo "   DB_HOST: " . getenv('DB_HOST') . "\n";
echo "   DB_PORT: " . getenv('DB_PORT') . "\n";
echo "   DB_NAME: " . getenv('DB_NAME') . "\n";
echo "   DB_USER: " . getenv('DB_USER') . "\n";
echo "   DB_PASS: " . (getenv('DB_PASS') ? '***' : 'NOT SET') . "\n";
?>
