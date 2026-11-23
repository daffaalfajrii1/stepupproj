<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Block;
use App\Models\Certificate;
use App\Models\Experience;
use App\Models\Faq;
use App\Models\Member;
use App\Models\Project;
use App\Models\Service;
use App\Models\TechItem;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    public function index()
    {
        $projects = $this->rows(Project::class);

        return view('home', [
            'projects' => $projects->take(6),
            'projectCount' => $projects->count(),
            'certificates' => $this->rows(Certificate::class),
            'achievements' => $this->rows(Achievement::class),
            'techItems' => $this->rows(TechItem::class),
            'experiences' => $this->rows(Experience::class),
            'services' => $this->byOrder(Service::class),
            'faqs' => $this->rows(Faq::class),
            'problems' => $this->blocks('problem'),
            'methods' => $this->blocks('method'),
            'principles' => $this->blocks('principle'),
            'members' => $this->members(),
        ]);
    }

    private function byOrder(string $model): Collection
    {
        try {
            return $model::query()->published()->orderBy('sort_order')->orderBy('id')->get();
        } catch (\Throwable) {
            return collect();
        }
    }

    private function rows(string $model): Collection
    {
        try {
            return $model::query()->published()->ordered()->get();
        } catch (\Throwable) {
            return collect();
        }
    }

    private function members(): Collection
    {
        try {
            return Member::query()->published()->orderBy('id')->get();
        } catch (\Throwable) {
            return collect();
        }
    }

    private function blocks(string $group): Collection
    {
        try {
            return Block::query()->published()->where('group', $group)->orderBy('sort_order')->orderBy('id')->get();
        } catch (\Throwable) {
            return collect();
        }
    }
}
