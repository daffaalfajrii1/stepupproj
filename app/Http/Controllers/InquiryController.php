<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Support\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        if ($request->filled('website')) {
            return redirect()->route('home');
        }

        $key = 'inquiry:'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, 6)) {
            return redirect(route('home').'#kontak')
                ->withErrors(['message' => 'Terlalu banyak kiriman. Coba lagi beberapa menit.'])
                ->withInput();
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'contact' => ['required', 'string', 'max:120'],
            'topic' => ['nullable', 'string', 'max:120'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        Inquiry::create($data);
        RateLimiter::hit($key, 600);

        $site = array_merge(config('site.defaults', []), \App\Models\Setting::map());
        $text = "Halo StepUp, saya {$data['name']}.\n"
            ."Kebutuhan: ".($data['topic'] ?: '-')."\n"
            .$data['message']."\n"
            ."Kontak: {$data['contact']}";
        $link = Site::whatsapp($site, $text);

        if (! $link) {
            return redirect(route('home').'#kontak')
                ->with('ok', 'Pesan tersimpan. Nomor WhatsApp belum diatur di admin.');
        }

        return redirect()->away($link);
    }
}
