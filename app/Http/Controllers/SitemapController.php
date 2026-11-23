<?php

namespace App\Http\Controllers;

use App\Models\Project;

class SitemapController extends Controller
{
    public function __invoke()
    {
        $urls = [
            ['loc' => route('home'), 'changefreq' => 'weekly', 'priority' => '1.0'],
            ['loc' => route('portfolio.index'), 'changefreq' => 'weekly', 'priority' => '0.8'],
        ];

        try {
            $projects = Project::query()->published()->ordered()->get(['slug', 'updated_at']);
            foreach ($projects as $project) {
                $urls[] = [
                    'loc' => route('projects.show', $project->slug),
                    'lastmod' => $project->updated_at?->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.6',
                ];
            }
        } catch (\Throwable) {
            // Tabel proyek belum ada. Sitemap tetap memuat halaman utama.
        }

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
