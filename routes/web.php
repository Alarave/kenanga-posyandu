<?php

// --- CONTROLLERS UMUM ---
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Web\ActivityLogController;
// --- CONTROLLERS ADMIN (LOKASI DI FOLDER 'Web') ---
use App\Http\Controllers\Web\ArticleController;
use App\Http\Controllers\Web\GalleryController;
use App\Http\Controllers\Web\GalleryFolderController;
use App\Http\Controllers\Web\MedicalRecordController;
use App\Http\Controllers\Web\PatientController;
use App\Http\Controllers\Web\PedukuhanController;
use App\Http\Controllers\Web\PosyanduController;
use App\Http\Controllers\Web\PublicArticleController;
use App\Http\Controllers\Web\PublicController;
use App\Http\Controllers\Web\ReportController;
// --- LIVEWIRE COMPONENTS ---
use App\Http\Controllers\Web\ScheduleController;
use App\Http\Controllers\Web\UserController;
use App\Livewire\Admin\Management\ArticleCreate;
use App\Livewire\Admin\Management\ArticleManagement;
use App\Livewire\Admin\Management\ArticleShow;
use App\Livewire\Admin\Management\ArticleUpdate;
use App\Livewire\Admin\Management\GalleryManagement;
use App\Livewire\Admin\Management\MedicalRecordManagement;
use App\Livewire\Admin\Management\PedukuhanManagement;
use App\Livewire\Admin\Management\PosyanduManagement;
use App\Livewire\Admin\Management\ScheduleCreate;
use App\Livewire\Admin\Management\ScheduleManagement;
use App\Livewire\Admin\Management\ScheduleUpdate;
use App\Livewire\Admin\Management\UserManagement;
use App\Livewire\Admin\MedicalRecord\BulkMeasurementEntry;
use App\Livewire\Admin\PatientManagement\GrowthChart;
use App\Livewire\Admin\PatientManagement\Index as PatientManagementIndex;
use App\Livewire\Admin\Settings\RolePermissionManagement;
use Illuminate\Support\Facades\Route;

// Home Page - Public Home
Route::get('/', [PublicController::class, 'home'])->name('public.home');

// Public routes
Route::get('/articles', [PublicArticleController::class, 'index'])->name('public.articles.index');
Route::get('/articles/{slug}', [PublicArticleController::class, 'show'])->name('public.articles.show');
Route::get('/about', [PublicController::class, 'about'])->name('public.about');
Route::get('/contact', [PublicController::class, 'contact'])->name('public.contact');

// Authentication Routes
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    // Throttle: maksimal 5 percobaan login per menit per IP (anti brute-force)
    Route::post('login', [LoginController::class, 'login'])->middleware('throttle:5,1');

});

// Protected Routes (Require Login)
Route::middleware(['auth'])->group(function () {

    // Dashboard (Admin Dashboard)
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Analytics
    Route::get('admin/analitik', function () {
        return view('admin.analytics.index');
    })->name('admin.analytics');

    // 1. PATIENT MANAGEMENT
    Route::get('admin/pasien', PatientManagementIndex::class)->name('admin.patients.index');
    Route::get('admin/pasien/create', [PatientController::class, 'create'])->name('admin.patients.create');
    // ... rest of patient routes
    Route::post('admin/pasien', [PatientController::class, 'store'])->name('admin.patients.store');
    Route::get('admin/pasien/import', [PatientController::class, 'importForm'])->name('admin.patients.import');
    Route::post('admin/pasien/import', [PatientController::class, 'import'])->name('admin.patients.import.store');
    Route::get('admin/pasien/template', [PatientController::class, 'downloadTemplate'])->name('admin.patients.template');
    Route::get('admin/pasien/{patient}', [PatientController::class, 'show'])->name('admin.patients.show');
    Route::get('admin/pasien/{patient}/edit', [PatientController::class, 'edit'])->name('admin.patients.edit');
    Route::get('admin/pasien/{patient}/growth-chart', GrowthChart::class)->name('admin.patients.growth-chart');
    Route::put('admin/pasien/{patient}', [PatientController::class, 'update'])->name('admin.patients.update');
    Route::delete('admin/pasien/{patient}', [PatientController::class, 'destroy'])->name('admin.patients.destroy');

    // 2. POSYANDU
    Route::get('admin/posyandu', PosyanduManagement::class)->name('admin.posyandu.index');
    Route::get('admin/posyandu/create', [PosyanduController::class, 'create'])->name('admin.posyandu.create');
    Route::post('admin/posyandu', [PosyanduController::class, 'store'])->name('admin.posyandu.store');
    Route::get('admin/posyandu/{posyandu}', [PosyanduController::class, 'show'])->name('admin.posyandu.show');
    Route::get('admin/posyandu/{posyandu}/edit', [PosyanduController::class, 'edit'])->name('admin.posyandu.edit');
    Route::put('admin/posyandu/{posyandu}', [PosyanduController::class, 'update'])->name('admin.posyandu.update');
    Route::delete('admin/posyandu/{posyandu}', [PosyanduController::class, 'destroy'])->name('admin.posyandu.destroy');

    // 3. SCHEDULES
    Route::get('admin/jadwal', ScheduleManagement::class)->name('admin.schedules.index');
    Route::get('admin/jadwal/create', ScheduleCreate::class)->name('admin.schedules.create');
    Route::get('admin/jadwal/{schedule}', [ScheduleController::class, 'show'])->name('admin.schedules.show');
    Route::get('admin/jadwal/{schedule}/edit', ScheduleUpdate::class)->name('admin.schedules.edit');
    Route::put('admin/jadwal/{schedule}', [ScheduleController::class, 'update'])->name('admin.schedules.update');
    Route::delete('admin/jadwal/{schedule}', [ScheduleController::class, 'destroy'])->name('admin.schedules.destroy');

    // 4. GALLERY
    Route::get('admin/galeri', GalleryManagement::class)->name('admin.gallery.index');
    // Folder
    Route::get('admin/galeri/create', [GalleryFolderController::class, 'create'])->name('admin.gallery.create');
    Route::post('admin/galeri', [GalleryFolderController::class, 'store'])->name('admin.gallery.store');
    Route::get('admin/galeri/{folder}', [GalleryFolderController::class, 'show'])->name('admin.gallery.show');
    Route::get('admin/galeri/{folder}/edit', [GalleryFolderController::class, 'edit'])->name('admin.gallery.edit');
    Route::put('admin/galeri/{folder}', [GalleryFolderController::class, 'update'])->name('admin.gallery.update');
    Route::delete('admin/galeri/{folder}', [GalleryFolderController::class, 'destroy'])->name('admin.gallery.destroy');
    // Media di dalam folder
    Route::get('admin/galeri/{folder}/media/create', [GalleryController::class, 'create'])->name('admin.gallery.media.create');
    Route::post('admin/galeri/{folder}/media', [GalleryController::class, 'store'])->name('admin.gallery.media.store');
    Route::delete('admin/galeri/{folder}/media/{gallery}', [GalleryController::class, 'destroy'])->name('admin.gallery.media.destroy');
    Route::put('admin/galeri/{folder}/media/{gallery}', [GalleryController::class, 'update'])->name('admin.gallery.media.update');

    // 5. ARTICLES
    Route::get('admin/artikel', ArticleManagement::class)->name('admin.articles.index');
    Route::get('admin/artikel/create', ArticleCreate::class)->name('admin.articles.create');
    Route::get('admin/artikel/{article}', ArticleShow::class)->name('admin.articles.show');
    Route::get('admin/artikel/{article}/edit', ArticleUpdate::class)->name('admin.articles.edit');
    // PUT and DELETE are handled by the components/service now, but we keep the show route if needed for public view/preview
    Route::delete('admin/artikel/{article}', [ArticleController::class, 'destroy'])->name('admin.articles.destroy');

    // 6. MEDICAL RECORDS
    Route::get('admin/rekam-medis', MedicalRecordManagement::class)->name('admin.medical-records.index');
    Route::get('admin/rekam-medis/bulk', BulkMeasurementEntry::class)->name('admin.medical-records.bulk');
    Route::get('admin/rekam-medis/import', [MedicalRecordController::class, 'importForm'])->name('admin.medical-records.import');
    Route::post('admin/rekam-medis/import', [MedicalRecordController::class, 'import'])->name('admin.medical-records.import.store');
    Route::get('admin/rekam-medis/template', [MedicalRecordController::class, 'downloadTemplate'])->name('admin.medical-records.template');
    Route::get('admin/rekam-medis/create', [MedicalRecordController::class, 'create'])->name('admin.medical-records.create');
    Route::post('admin/rekam-medis', [MedicalRecordController::class, 'store'])->name('admin.medical-records.store');

    Route::get('admin/rekam-medis/{medicalRecord}', [MedicalRecordController::class, 'show'])->name('admin.medical-records.show');
    Route::get('admin/rekam-medis/{medicalRecord}/edit', [MedicalRecordController::class, 'edit'])->name('admin.medical-records.edit');
    Route::put('admin/rekam-medis/{medicalRecord}', [MedicalRecordController::class, 'update'])->name('admin.medical-records.update');
    Route::delete('admin/rekam-medis/{medicalRecord}', [MedicalRecordController::class, 'destroy'])->name('admin.medical-records.destroy');

    // 7. USERS
    Route::middleware(['role:superadmin'])->group(function () {
        // Role & Permission Management
        Route::get('admin/pengaturan/peran', RolePermissionManagement::class)->name('admin.settings.roles');

        Route::get('admin/pengguna', UserManagement::class)->name('admin.users.index');
        Route::get('admin/pengguna/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('admin/pengguna', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('admin/pengguna/{user}', [UserController::class, 'show'])->name('admin.users.show');
        Route::get('admin/pengguna/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('admin/pengguna/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('admin/pengguna/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });

    // ---------------------------------------------------------
    // 8. ACTIVITY LOGS (CONTROLLER)
    // ---------------------------------------------------------
    Route::middleware(['role:superadmin'])->group(function () {
        Route::get('admin/log-aktivitas', [ActivityLogController::class, 'index'])->name('admin.activity-logs.index');
        Route::get('admin/log-aktivitas/{activityLog}', [ActivityLogController::class, 'show'])->name('admin.activity-logs.show');
        Route::get('admin/log-aktivitas/statistics', [ActivityLogController::class, 'statistics'])->name('admin.activity-logs.statistics');
    });

    // ---------------------------------------------------------
    // 9. REPORTS (MONTHLY REPORTS - Livewire)
    // ---------------------------------------------------------
    Route::middleware(['role:superadmin,admin,kader'])->group(function () {
        Route::get('admin/laporan', [ReportController::class, 'index'])->name('admin.reports.index');
        Route::post('admin/laporan/export-excel', [ReportController::class, 'exportExcel'])->name('admin.reports.export-excel');
        Route::post('admin/laporan/export-pdf', [ReportController::class, 'exportPdf'])->name('admin.reports.export-pdf');
        Route::get('admin/laporan/individual/{patient}', [ReportController::class, 'showIndividual'])->name('admin.reports.individual');
        Route::post('admin/laporan/individual/{patient}/export-pdf', [ReportController::class, 'exportIndividualPdf'])->name('admin.reports.individual.pdf');
        Route::post('admin/laporan/individual/{patient}/export-excel', [ReportController::class, 'exportIndividualExcel'])->name('admin.reports.individual.excel');
    });

    // 10. PEDUKUHANS
    Route::get('admin/pedukuhans', PedukuhanManagement::class)->name('admin.pedukuhans.index');
    Route::get('admin/pedukuhans/create', [PedukuhanController::class, 'create'])->name('admin.pedukuhans.create');
    Route::post('admin/pedukuhans', [PedukuhanController::class, 'store'])->name('admin.pedukuhans.store');
    Route::get('admin/pedukuhans/{pedukuhan}', [PedukuhanController::class, 'show'])->name('admin.pedukuhans.show');
    Route::get('admin/pedukuhans/{pedukuhan}/edit', [PedukuhanController::class, 'edit'])->name('admin.pedukuhans.edit');
    Route::put('admin/pedukuhans/{pedukuhan}', [PedukuhanController::class, 'update'])->name('admin.pedukuhans.update');
    Route::delete('admin/pedukuhans/{pedukuhan}', [PedukuhanController::class, 'destroy'])->name('admin.pedukuhans.destroy');

    // 11. COMPATIBILITY ALIASES (English paths for tests and legacy links)
    Route::get('admin/analytics', function () { return redirect()->route('admin.analytics'); });
    Route::get('admin/patients', PatientManagementIndex::class);
    Route::get('admin/patients/create', [PatientController::class, 'create']);
    Route::post('admin/patients', [PatientController::class, 'store']);
    Route::get('admin/patients/import', [PatientController::class, 'importForm']);
    Route::post('admin/patients/import', [PatientController::class, 'import']);
    Route::get('admin/patients/template', [PatientController::class, 'downloadTemplate']);
    Route::get('admin/patients/{patient}', [PatientController::class, 'show']);
    Route::get('admin/patients/{patient}/edit', [PatientController::class, 'edit']);
    Route::get('admin/patients/{patient}/growth-chart', GrowthChart::class);
    Route::put('admin/patients/{patient}', [PatientController::class, 'update']);
    Route::delete('admin/patients/{patient}', [PatientController::class, 'destroy']);

    Route::get('admin/schedules', ScheduleManagement::class);
    Route::get('admin/schedules/create', ScheduleCreate::class);
    Route::get('admin/schedules/{schedule}', [ScheduleController::class, 'show']);
    Route::get('admin/schedules/{schedule}/edit', ScheduleUpdate::class);
    Route::put('admin/schedules/{schedule}', [ScheduleController::class, 'update']);
    Route::delete('admin/schedules/{schedule}', [ScheduleController::class, 'destroy']);

    Route::get('admin/gallery', GalleryManagement::class);
    Route::get('admin/gallery/create', [GalleryFolderController::class, 'create']);
    Route::post('admin/gallery', [GalleryFolderController::class, 'store']);
    Route::get('admin/gallery/{folder}', [GalleryFolderController::class, 'show']);
    Route::get('admin/gallery/{folder}/edit', [GalleryFolderController::class, 'edit']);
    Route::put('admin/gallery/{folder}', [GalleryFolderController::class, 'update']);
    Route::delete('admin/gallery/{folder}', [GalleryFolderController::class, 'destroy']);
    Route::get('admin/gallery/{folder}/media/create', [GalleryController::class, 'create']);
    Route::post('admin/gallery/{folder}/media', [GalleryController::class, 'store']);
    Route::delete('admin/gallery/{folder}/media/{gallery}', [GalleryController::class, 'destroy']);
    Route::put('admin/gallery/{folder}/media/{gallery}', [GalleryController::class, 'update']);

    Route::get('admin/articles', ArticleManagement::class);
    Route::get('admin/articles/create', ArticleCreate::class);
    Route::get('admin/articles/{article}', ArticleShow::class);
    Route::get('admin/articles/{article}/edit', ArticleUpdate::class);
    Route::delete('admin/articles/{article}', [ArticleController::class, 'destroy']);

    Route::get('admin/medical-records', MedicalRecordManagement::class);
    Route::get('admin/medical-records/bulk', BulkMeasurementEntry::class);
    Route::get('admin/medical-records/import', [MedicalRecordController::class, 'importForm']);
    Route::post('admin/medical-records/import', [MedicalRecordController::class, 'import']);
    Route::get('admin/medical-records/template', [MedicalRecordController::class, 'downloadTemplate']);
    Route::get('admin/medical-records/create', [MedicalRecordController::class, 'create']);
    Route::post('admin/medical-records', [MedicalRecordController::class, 'store']);
    Route::get('admin/medical-records/{medicalRecord}', [MedicalRecordController::class, 'show']);
    Route::get('admin/medical-records/{medicalRecord}/edit', [MedicalRecordController::class, 'edit']);
    Route::put('admin/medical-records/{medicalRecord}', [MedicalRecordController::class, 'update']);
    Route::delete('admin/medical-records/{medicalRecord}', [MedicalRecordController::class, 'destroy']);

    Route::middleware(['role:superadmin'])->group(function () {
        Route::get('admin/settings/roles', RolePermissionManagement::class);
        Route::get('admin/users', UserManagement::class);
        Route::get('admin/users/create', [UserController::class, 'create']);
        Route::post('admin/users', [UserController::class, 'store']);
        Route::get('admin/users/{user}', [UserController::class, 'show']);
        Route::get('admin/users/{user}/edit', [UserController::class, 'edit']);
        Route::put('admin/users/{user}', [UserController::class, 'update']);
        Route::delete('admin/users/{user}', [UserController::class, 'destroy']);
        Route::get('admin/activity-logs', [ActivityLogController::class, 'index']);
        Route::get('admin/activity-logs/{activityLog}', [ActivityLogController::class, 'show']);
        Route::get('admin/activity-logs/statistics', [ActivityLogController::class, 'statistics']);
    });

    Route::middleware(['role:superadmin,admin,kader'])->group(function () {
        Route::get('admin/reports', [ReportController::class, 'index']);
        Route::post('admin/reports/export-excel', [ReportController::class, 'exportExcel']);
        Route::post('admin/reports/export-pdf', [ReportController::class, 'exportPdf']);
        Route::get('admin/reports/individual/{patient}', [ReportController::class, 'showIndividual']);
        Route::post('admin/reports/individual/{patient}/export-pdf', [ReportController::class, 'exportIndividualPdf']);
        Route::post('admin/reports/individual/{patient}/export-excel', [ReportController::class, 'exportIndividualExcel']);
    });

    // Logout
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

// Route for 404 page
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
