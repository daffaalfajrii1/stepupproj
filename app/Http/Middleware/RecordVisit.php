<?php

namespace App\Http\Middleware;

use App\Models\DailyVisit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecordVisit
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($this->shouldCount($request, $response)) {
            $today = now()->toDateString();
            $request->session()->put('visit_day', $today);
            DailyVisit::query()->firstOrCreate(['visited_on' => $today], ['total' => 0]);
            DailyVisit::query()->whereDate('visited_on', $today)->increment('total');
        }

        return $response;
    }

    private function shouldCount(Request $request, Response $response): bool
    {
        if (! $request->isMethod('GET') || $response->getStatusCode() >= 400) {
            return false;
        }

        if ($request->user() || $request->ajax() || $request->expectsJson()) {
            return false;
        }

        if ($request->is('admin', 'admin/*', 'up', 'proyek/*/preview')) {
            return false;
        }

        $type = (string) $response->headers->get('Content-Type');
        if ($type !== '' && ! str_contains($type, 'text/html')) {
            return false;
        }

        $agent = strtolower((string) $request->userAgent());
        if ($agent === '' || preg_match('/bot|crawl|spider|slurp|preview|facebookexternalhit|whatsapp/i', $agent)) {
            return false;
        }

        return $request->session()->get('visit_day') !== now()->toDateString();
    }
}
