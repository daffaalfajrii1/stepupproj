<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class ProjectController extends Controller
{
    private string $fetchedUrl = '';

    public function index()
    {
        $projects = Project::query()->published()->ordered()->get();

        return view('projects.index', compact('projects'));
    }

    public function show(string $slug)
    {
        $project = Project::query()->published()->where('slug', $slug)->firstOrFail();
        $more = Project::query()->published()->whereKeyNot($project->id)->ordered()->limit(3)->get();

        return view('projects.show', compact('project', 'more'));
    }

    public function preview(string $slug)
    {
        $project = Project::query()->published()->where('slug', $slug)->firstOrFail();
        $url = $this->publicUrl((string) $project->live_url);

        if ($url === null) {
            return $this->previewMessage('URL live tidak valid.');
        }

        try {
            $response = $this->fetchPublic($url);
        } catch (\Throwable) {
            return $this->previewMessage('Pratinjau tidak bisa dimuat. Buka situs lewat tombol di samping.');
        }

        if (! $response instanceof Response || ! $response->successful()) {
            return $this->previewMessage('Situs tujuan tidak merespons.');
        }

        $body = $response->body();
        if (strlen($body) > 3_000_000) {
            return $this->previewMessage('Halaman terlalu besar untuk pratinjau.');
        }

        $rawType = (string) $response->header('Content-Type');
        $type = strtolower(trim(explode(';', $rawType)[0] ?? ''));
        $headers = [
            'X-Frame-Options' => 'SAMEORIGIN',
            'Content-Security-Policy' => "frame-ancestors 'self'",
            'Cache-Control' => 'private, max-age=120',
            'X-Robots-Tag' => 'noindex, nofollow',
        ];

        if (str_contains($type, 'html') || $type === '') {
            return response($this->prepareHtml($body, $this->fetchedUrl ?: $url), 200, $headers + [
                'Content-Type' => 'text/html; charset=UTF-8',
            ]);
        }

        return response($body, 200, $headers + ['Content-Type' => $type]);
    }

    private function fetchPublic(string $url): Response
    {
        $current = $url;
        $response = null;
        $this->fetchedUrl = $url;

        for ($hop = 0; $hop < 4; $hop++) {
            $response = Http::withOptions(['allow_redirects' => false])
                ->timeout(15)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                    'Accept' => 'text/html,application/xhtml+xml',
                ])
                ->get($current);

            if (! in_array($response->status(), [301, 302, 303, 307, 308], true)) {
                return $response;
            }

            $next = $this->resolveUrl($current, (string) $response->header('Location'));
            if ($next === null) {
                return $response;
            }
            $current = $next;
            $this->fetchedUrl = $current;
        }

        return $response;
    }

    private function prepareHtml(string $html, string $pageUrl): string
    {
        $parts = parse_url($pageUrl) ?: [];
        $origin = ($parts['scheme'] ?? 'https').'://'.($parts['host'] ?? '');
        if (! empty($parts['port'])) {
            $origin .= ':'.$parts['port'];
        }
        $origin .= '/';
        $base = '<base href="'.e($origin).'">';

        $html = preg_replace('/<meta[^>]+http-equiv=["\'](?:content-security-policy|x-frame-options)["\'][^>]*>/i', '', $html) ?? $html;

        if (preg_match('/<head[^>]*>/i', $html)) {
            return preg_replace('/<head([^>]*)>/i', '<head$1>'.$base, $html, 1) ?? $html;
        }

        return $base.$html;
    }

    private function previewMessage(string $message)
    {
        $safe = e($message);

        return response(
            '<!doctype html><html><body style="margin:0;background:#111;color:#d6d3d1;font:16px sans-serif;display:grid;place-items:center;min-height:100vh;padding:24px;text-align:center"><p>'.$safe.'</p></body></html>',
            200,
            ['Content-Type' => 'text/html; charset=UTF-8', 'X-Frame-Options' => 'SAMEORIGIN']
        );
    }

    private function publicUrl(?string $url): ?string
    {
        $url = trim((string) $url);
        if (! $this->isPublicUrl($url)) {
            return null;
        }

        return $url;
    }

    private function resolveUrl(string $base, string $location): ?string
    {
        $location = trim($location);
        if ($location === '') {
            return null;
        }
        if (preg_match('#^https?://#i', $location)) {
            return $this->isPublicUrl($location) ? $location : null;
        }
        $parts = parse_url($base) ?: [];
        $origin = ($parts['scheme'] ?? 'https').'://'.($parts['host'] ?? '');
        if (! empty($parts['port'])) {
            $origin .= ':'.$parts['port'];
        }
        $absolute = str_starts_with($location, '/') ? $origin.$location : $origin.'/'.ltrim($location, '/');

        return $this->isPublicUrl($absolute) ? $absolute : null;
    }

    private function isPublicUrl(string $url): bool
    {
        $parts = parse_url($url);
        if (! in_array(strtolower((string) ($parts['scheme'] ?? '')), ['http', 'https'], true)) {
            return false;
        }
        $host = strtolower((string) ($parts['host'] ?? ''));
        if ($host === '' || $host === 'localhost' || str_ends_with($host, '.local')) {
            return false;
        }
        if (filter_var($host, FILTER_VALIDATE_IP)) {
            return $this->isPublicIp($host);
        }

        $ips = [];
        foreach (dns_get_record($host, DNS_A + DNS_AAAA) ?: [] as $record) {
            $ip = $record['ip'] ?? $record['ipv6'] ?? null;
            if ($ip) {
                $ips[] = $ip;
            }
        }
        if ($ips === []) {
            $resolved = gethostbyname($host);
            if ($resolved === $host) {
                return false;
            }
            $ips[] = $resolved;
        }

        foreach ($ips as $ip) {
            if (! $this->isPublicIp($ip)) {
                return false;
            }
        }

        return true;
    }

    private function isPublicIp(string $ip): bool
    {
        return (bool) filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
    }
}
