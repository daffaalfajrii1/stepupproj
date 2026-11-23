<?php

namespace App\Support;

class Site
{
    public static function whatsapp(array $site, ?string $text = null): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) ($site['whatsapp'] ?? '')) ?? '';

        if ($digits === '') {
            return null;
        }

        if (str_starts_with($digits, '0')) {
            $digits = '62'.substr($digits, 1);
        }

        $text ??= (string) ($site['wa_greeting'] ?? '');

        return 'https://wa.me/'.$digits.'?text='.rawurlencode($text);
    }

    public static function mapSrc(?string $html): ?string
    {
        $html = trim((string) $html);
        if ($html === '') {
            return null;
        }

        $candidate = $html;
        if (preg_match('/<iframe\b[^>]*\bsrc\s*=\s*(["\'])(.*?)\1/is', $html, $match)) {
            $candidate = html_entity_decode($match[2], ENT_QUOTES);
        }

        $candidate = trim(html_entity_decode($candidate, ENT_QUOTES));
        if (! str_starts_with(strtolower($candidate), 'https://')) {
            return null;
        }

        $parts = parse_url($candidate);
        $host = strtolower((string) ($parts['host'] ?? ''));
        if ($host === '' || isset($parts['user'])) {
            return null;
        }

        foreach (['google.com', 'google.co.id', 'openstreetmap.org'] as $root) {
            if ($host === $root || str_ends_with($host, '.'.$root)) {
                return $candidate;
            }
        }

        return null;
    }
}
