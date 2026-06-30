<?php

namespace App\Support;

use Illuminate\Foundation\Vite as FoundationVite;

class CustomVite extends FoundationVite
{
    /**
     * Cache the hot running status for the duration of the request.
     *
     * @var bool|null
     */
    protected static $isRunningHotCache = null;

    /**
     * Determine if the Vite dev server is running.
     *
     * @return bool
     */
    public function isRunningHot()
    {
        if (static::$isRunningHotCache !== null) {
            return static::$isRunningHotCache;
        }

        $hotPath = $this->hotFile();

        if (! file_exists($hotPath)) {
            return static::$isRunningHotCache = false;
        }

        // Read URL from the hot file
        $url = trim(file_get_contents($hotPath));

        // Parse the URL to extract host and port
        $parts = parse_url($url);
        $host = isset($parts['host']) ? $parts['host'] : '127.0.0.1';
        $port = isset($parts['port']) ? $parts['port'] : 5173;

        // Clean up loopback address formats (e.g. resolve IPv6 to IPv4 loopback)
        if ($host === '[::1]' || $host === '::1') {
            $host = '127.0.0.1';
        }

        // Attempt a quick TCP connection test (50ms timeout)
        $connection = @fsockopen($host, $port, $errno, $errstr, 0.05);

        if (is_resource($connection)) {
            fclose($connection);

            return static::$isRunningHotCache = true;
        }

        // If the Vite server is unreachable, delete the stale hot file
        @unlink($hotPath);

        return static::$isRunningHotCache = false;
    }
}
