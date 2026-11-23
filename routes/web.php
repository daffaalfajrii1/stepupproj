<?php

use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlockController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TechItemController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/portofolio', [ProjectController::class, 'index'])->name('portfolio.index');
Route::get('/proyek/{slug}/preview', [ProjectController::class, 'preview'])->name('projects.preview');
Route::get('/proyek/{slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::post('/inquiries', [InquiryController::class, 'store'])->name('inquiries.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        if (! auth()->check()) {
            return view('admin.login');
        }

        return app(DashboardController::class)->index();
    })->name('dashboard');

    Route::middleware('guest')->group(function () {
        Route::redirect('login', '/admin');
        Route::post('login', [AuthController::class, 'store'])->name('login.store');
    });

    Route::middleware('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'destroy'])->name('logout');
        Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
        Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
        Route::post('password', [SettingController::class, 'password'])->name('password');
        Route::get('inquiries', [AdminInquiryController::class, 'index'])->name('inquiries.index');
        Route::delete('inquiries/{inquiry}', [AdminInquiryController::class, 'destroy'])->name('inquiries.destroy');

        Route::resource('members', MemberController::class)->except(['show']);
        Route::resource('projects', AdminProjectController::class)->except(['show']);
        Route::resource('certificates', CertificateController::class)->except(['show']);
        Route::resource('achievements', AchievementController::class)->except(['show']);
        Route::resource('tech-items', TechItemController::class)->except(['show']);
        Route::resource('experiences', ExperienceController::class)->except(['show']);
        Route::resource('services', ServiceController::class)->except(['show']);
        Route::resource('faqs', FaqController::class)->except(['show']);
        Route::resource('blocks', BlockController::class)->except(['show']);
    });
});
