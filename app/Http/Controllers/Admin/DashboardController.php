<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\DailyVisit;
use App\Models\Inquiry;
use App\Models\Project;
use App\Models\TechItem;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'counts' => [
                'projects' => Project::count(),
                'certificates' => Certificate::count(),
                'tech' => TechItem::count(),
                'inquiries' => Inquiry::count(),
                'visits' => (int) DailyVisit::query()->whereDate('visited_on', today())->value('total'),
            ],
            'projects' => Project::query()->latest()->limit(5)->get(),
            'inquiries' => Inquiry::query()->latest()->limit(5)->get(),
            'defaultPassword' => Hash::check('StepUp#2026', (string) auth()->user()->password),
            'placeholderWa' => preg_replace('/\D+/', '', (string) ($this->siteWhatsapp())) === '6281234567890',
        ]);
    }

    private function siteWhatsapp(): string
    {
        return (string) \App\Models\Setting::get('whatsapp', '');
    }
}
