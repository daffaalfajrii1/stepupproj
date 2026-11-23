<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        return view('admin.settings', [
            'groups' => $this->groups(),
        ]);
    }

    public function update(Request $request)
    {
        $rules = [];
        foreach ($this->groups() as $group) {
            foreach ($group['fields'] as $field) {
                $rules[$field['name']] = $field['rules'];
            }
        }
        $data = $request->validate($rules + [
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        unset($data['logo']);
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('brand', 'public');
        }

        Setting::putMany($data);

        return redirect()->route('admin.settings.edit')->with('ok', 'Pengaturan disimpan.');
    }

    public function password(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $request->user()->update(['password' => $request->password]);

        return redirect()->route('admin.settings.edit')->with('ok', 'Kata sandi diperbarui.');
    }

    private function groups(): array
    {
        return [
            [
                'title' => 'Identitas',
                'fields' => [
                    ['name' => 'site_name', 'label' => 'Nama situs', 'rules' => 'required|string|max:80'],
                    ['name' => 'email', 'label' => 'Email', 'rules' => 'nullable|email|max:120'],
                    ['name' => 'phone', 'label' => 'Nomor telepon', 'rules' => 'nullable|string|max:30', 'help' => 'Ditampilkan di footer. Boleh diawali 0 atau 62.'],
                    ['name' => 'address', 'label' => 'Alamat', 'type' => 'textarea', 'wide' => true, 'rules' => 'nullable|string|max:240'],
                    ['name' => 'map_embed', 'label' => 'Embed peta', 'type' => 'textarea', 'wide' => true, 'rows' => 6, 'rules' => 'nullable|string|max:8000', 'help' => 'Di Google Maps pilih Bagikan, lalu Sematkan peta, salin HTML-nya, dan tempel di sini.'],
                    ['name' => 'location', 'label' => 'Lokasi singkat', 'rules' => 'nullable|string|max:80'],
                    ['name' => 'meta_title', 'label' => 'Judul SEO', 'wide' => true, 'rules' => 'required|string|max:160'],
                    ['name' => 'meta_description', 'label' => 'Deskripsi SEO', 'type' => 'textarea', 'wide' => true, 'rules' => 'required|string|max:300'],
                    ['name' => 'footer_note', 'label' => 'Catatan footer', 'wide' => true, 'rules' => 'nullable|string|max:200'],
                    ['name' => 'instagram', 'label' => 'Instagram', 'wide' => true, 'rules' => 'nullable|url|max:200', 'help' => 'URL lengkap, misalnya https://www.instagram.com/nama'],
                    ['name' => 'tiktok', 'label' => 'TikTok', 'wide' => true, 'rules' => 'nullable|url|max:200'],
                    ['name' => 'linkedin', 'label' => 'LinkedIn', 'wide' => true, 'rules' => 'nullable|url|max:200'],
                    ['name' => 'youtube', 'label' => 'YouTube', 'wide' => true, 'rules' => 'nullable|url|max:200'],
                    ['name' => 'facebook', 'label' => 'Facebook', 'wide' => true, 'rules' => 'nullable|url|max:200'],
                    ['name' => 'x', 'label' => 'X', 'wide' => true, 'rules' => 'nullable|url|max:200'],
                    ['name' => 'github', 'label' => 'GitHub', 'wide' => true, 'rules' => 'nullable|url|max:200'],
                ],
            ],
            [
                'title' => 'Hero',
                'fields' => [
                    ['name' => 'hero_kicker', 'label' => 'Label kecil', 'rules' => 'required|string|max:80'],
                    ['name' => 'hero_kicker_strong', 'label' => 'Label tebal', 'rules' => 'nullable|string|max:80'],
                    ['name' => 'hero_title', 'label' => 'Judul', 'rules' => 'required|string|max:120'],
                    ['name' => 'hero_accent', 'label' => 'Frasa aksen', 'rules' => 'required|string|max:120'],
                    ['name' => 'hero_subtitle', 'label' => 'Subjudul', 'type' => 'textarea', 'wide' => true, 'rules' => 'required|string|max:400'],
                ],
            ],
            [
                'title' => 'WhatsApp',
                'fields' => [
                    ['name' => 'whatsapp', 'label' => 'Nomor WhatsApp', 'rules' => 'nullable|string|max:20', 'help' => 'Pakai format 62812..., tanpa tanda plus.'],
                    ['name' => 'wa_greeting', 'label' => 'Pesan pembuka', 'wide' => true, 'rules' => 'nullable|string|max:200'],
                    ['name' => 'wa_panel_title', 'label' => 'Judul panel', 'rules' => 'nullable|string|max:80'],
                    ['name' => 'wa_panel_body', 'label' => 'Isi panel', 'type' => 'textarea', 'wide' => true, 'rules' => 'nullable|string|max:240'],
                ],
            ],
            [
                'title' => 'Cerita halaman',
                'fields' => [
                    ['name' => 'problem_kicker', 'label' => 'Label masalah', 'rules' => 'nullable|string|max:80'],
                    ['name' => 'problem_title', 'label' => 'Judul masalah', 'wide' => true, 'rules' => 'required|string|max:180'],
                    ['name' => 'problem_body', 'label' => 'Pengantar masalah', 'type' => 'textarea', 'wide' => true, 'rules' => 'nullable|string|max:800'],
                    ['name' => 'problem_close', 'label' => 'Penutup masalah', 'type' => 'textarea', 'wide' => true, 'rules' => 'nullable|string|max:300'],
                    ['name' => 'method_kicker', 'label' => 'Label cara kerja', 'rules' => 'nullable|string|max:80'],
                    ['name' => 'method_title', 'label' => 'Judul cara kerja', 'wide' => true, 'rules' => 'required|string|max:180'],
                    ['name' => 'method_body', 'label' => 'Pengantar cara kerja', 'type' => 'textarea', 'wide' => true, 'rules' => 'nullable|string|max:600'],
                    ['name' => 'principle_kicker', 'label' => 'Label alasan', 'rules' => 'nullable|string|max:80'],
                    ['name' => 'principle_title', 'label' => 'Judul alasan', 'wide' => true, 'rules' => 'required|string|max:180'],
                    ['name' => 'principle_body', 'label' => 'Pengantar alasan', 'type' => 'textarea', 'wide' => true, 'rules' => 'nullable|string|max:600'],
                    ['name' => 'services_title', 'label' => 'Judul layanan', 'wide' => true, 'rules' => 'required|string|max:180'],
                    ['name' => 'services_close', 'label' => 'Penutup layanan', 'type' => 'textarea', 'wide' => true, 'rules' => 'nullable|string|max:300'],
                    ['name' => 'manifesto', 'label' => 'Kalimat tengah', 'type' => 'textarea', 'wide' => true, 'rules' => 'nullable|string|max:240'],
                    ['name' => 'about_title', 'label' => 'Judul tentang', 'rules' => 'required|string|max:120'],
                    ['name' => 'about_role', 'label' => 'Peran', 'rules' => 'nullable|string|max:160'],
                    ['name' => 'about_kicker', 'label' => 'Label tentang', 'rules' => 'nullable|string|max:80'],
                    ['name' => 'about_body', 'label' => 'Tentang', 'type' => 'textarea', 'wide' => true, 'rules' => 'nullable|string|max:2500'],
                    ['name' => 'cta_title', 'label' => 'Judul ajakan', 'wide' => true, 'rules' => 'required|string|max:180'],
                    ['name' => 'cta_subtitle', 'label' => 'Subjudul ajakan', 'type' => 'textarea', 'wide' => true, 'rules' => 'nullable|string|max:300'],
                    ['name' => 'stats_years', 'label' => 'Angka tahun', 'rules' => 'nullable|string|max:12'],
                    ['name' => 'stats_years_label', 'label' => 'Label tahun', 'rules' => 'nullable|string|max:80'],
                ],
            ],
        ];
    }
}
