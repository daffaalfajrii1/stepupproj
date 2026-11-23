<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;

class InquiryController extends Controller
{
    public function index()
    {
        return view('admin.inquiries.index', [
            'items' => Inquiry::query()->latest()->limit(100)->get(),
        ]);
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();

        return redirect()->route('admin.inquiries.index')->with('ok', 'Pesan dihapus.');
    }
}
