<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

use App\Http\Livewire\UserDashboard;
use App\Http\Livewire\PatientManagement;
use App\Http\Livewire\ScheduleManagement;
use App\Http\Livewire\GalleryManagement;
use App\Http\Livewire\ArticleManagement;
use App\Http\Livewire\MedicalRecordManagement;
use App\Http\Livewire\PedukuhanManagement;
use App\Http\Livewire\SearchComponent;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', UserDashboard::class)->name('admin.dashboard');
    Route::get('/admin/patients', PatientManagement::class)->name('admin.patients');
    Route::get('/admin/schedules', ScheduleManagement::class)->name('admin.schedules');
    Route::get('/admin/galleries', GalleryManagement::class)->name('admin.galleries');
    Route::get('/admin/articles', ArticleManagement::class)->name('admin.articles');
    Route::get('/admin/medical-records', MedicalRecordManagement::class)->name('admin.medical-records');
    Route::get('/admin/pedukuhans', PedukuhanManagement::class)->name('admin.pedukuhans');
    Route::get('/admin/search', SearchComponent::class)->name('admin.search');
});

require __DIR__.'/auth.php';