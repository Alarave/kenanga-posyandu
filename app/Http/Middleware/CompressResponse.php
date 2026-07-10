<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CompressResponse
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Do not compress binary file responses or streamed responses
        if ($response instanceof BinaryFileResponse || $response instanceof StreamedResponse) {
            return $response;
        }

        // Check if compression is supported and headers are not sent
        if (in_array('gzip', $request->getEncodings()) && function_exists('gzencode') && ! headers_sent()) {
            $contentType = $response->headers->get('Content-Type');

            // Only compress text-based responses (HTML, CSS, JS, JSON)
            if ($contentType && (
                str_contains($contentType, 'text/html') ||
                str_contains($contentType, 'application/json') ||
                str_contains($contentType, 'text/plain') ||
                str_contains($contentType, 'text/css') ||
                str_contains($contentType, 'application/javascript')
            )) {
                $content = $response->getContent();

                // Only compress if the content is not empty and not already compressed
                if (! empty($content) && $response->headers->get('Content-Encoding') === null) {
                    $compressedContent = gzencode($content, 5); // Balanced compression level

                    if ($compressedContent !== false) {
                        $response->setContent($compressedContent);
                        $response->headers->set('Content-Encoding', 'gzip');
                        $response->headers->set('Content-Length', strlen($compressedContent));
                    }
                }
            }
        }

        return $response;
    }
}
