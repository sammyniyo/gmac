<?php

namespace App\Http\Middleware;

use App\Models\VisitorLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (!$this->shouldTrack($request, $response)) {
            return $response;
        }

        try {
            $ipAddress = $request->ip() ?? 'unknown';
            $userAgent = trim((string) $request->userAgent());
            $sessionId = $request->hasSession() ? $request->session()->getId() : null;

            VisitorLog::create([
                'path' => '/'.ltrim($request->path(), '/'),
                'visitor_hash' => hash('sha256', $ipAddress.'|'.strtolower($userAgent)),
                'session_id' => $sessionId,
                'ip_hash' => hash('sha256', $ipAddress),
                'user_agent' => $userAgent !== '' ? substr($userAgent, 0, 512) : null,
                'visited_at' => now(),
            ]);
        } catch (\Throwable $exception) {
            // Tracking should never block page delivery.
        }

        return $response;
    }

    protected function shouldTrack(Request $request, Response $response): bool
    {
        if (!$request->isMethod('GET')) {
            return false;
        }

        if ($request->expectsJson() || $request->ajax()) {
            return false;
        }

        if ($response->getStatusCode() >= 400) {
            return false;
        }

        $contentType = strtolower((string) $response->headers->get('content-type', ''));
        if ($contentType !== '' && !str_contains($contentType, 'text/html')) {
            return false;
        }

        $userAgent = strtolower((string) $request->userAgent());
        if ($userAgent !== '' && preg_match('/bot|spider|crawl|slurp|preview/', $userAgent)) {
            return false;
        }

        return true;
    }
}
