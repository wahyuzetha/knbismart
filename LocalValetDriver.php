<?php

class LocalValetDriver extends Valet\Drivers\BasicValetDriver
{
    public function serves(string $sitePath, string $siteName, string $uri): bool
    {
        return true;
    }

    public function isStaticFile(string $sitePath, string $siteName, string $uri)
    {
        if (file_exists($staticFilePath = $sitePath . $uri) && is_file($staticFilePath)) {
            return $staticFilePath;
        }

        return false;
    }

    public function frontControllerPath(string $sitePath, string $siteName, string $uri): ?string
    {
        $trimmedUri = rtrim($uri, '/');

        if ($trimmedUri === '' || $trimmedUri === '/') {
            return $sitePath . '/login.php';
        }

        if (file_exists($sitePath . $trimmedUri . '.php')) {
            return $sitePath . $trimmedUri . '.php';
        }

        if (file_exists($sitePath . $trimmedUri . '/index.php')) {
            return $sitePath . $trimmedUri . '/index.php';
        }

        if (file_exists($sitePath . $trimmedUri) && is_file($sitePath . $trimmedUri)) {
            return $sitePath . $trimmedUri;
        }

        return $sitePath . '/index.php';
    }
}
