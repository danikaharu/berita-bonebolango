<?php

namespace App\Http\Middleware;

use Closure;

class SecurityHeaders
{
    private $unwantedHeaders = ['X-Powered-By', 'server', 'Server'];

    /**
     * @param $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (!app()->environment('testing')) {
            $response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade');
            $response->headers->set('X-XSS-Protection', '1; mode=block');
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
            $response->headers->set('Expect-CT', 'enforce, max-age=30');
            $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self' https://cdnjs.cloudflare.com ajax.googleapis.com cdn.datatables.net cdn.jsdelivr.net code.jquery.com www.google-analytics.com  www.googletagmanager.com 'unsafe-inline' 'unsafe-eval'; style-src 'self' cdn.datatables.net cdnjs.cloudflare.com cdn.jsdelivr.net fonts.googleapis.com 'unsafe-inline'; img-src 'self' * data:; font-src 'self' fonts.gstatic.com cdnjs.cloudflare.com data: ; connect-src 'self' www.google-analytics.com ; media-src 'self'; frame-src 'self' www.google.com; object-src 'none'; base-uri 'self'; report-uri ");
            $response->headers->set('Permissions-Policy', 'autoplay=(self), camera=(), encrypted-media=(self), fullscreen=(), geolocation=(self), gyroscope=(self), magnetometer=(), microphone=(), midi=(), payment=(), sync-xhr=(self), usb=()');
            $this->removeUnwantedHeaders($this->unwantedHeaders);
        }

        return $response;
    }

    /**
     * @param $headers
     */
    private function removeUnwantedHeaders($headers): void
    {
        foreach ($headers as $header) {
            header_remove($header);
        }
    }
}
