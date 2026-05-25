<?php

namespace App\View\Components\Layouts\App;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Navbar extends Component
{
    public string $pageTitle = 'Dashboard';
    public string $pageSubtitle = 'Sistem Informasi Posyandu';
    public $user;
    public string $name;
    public string $initials;
    public string $role;
    public string $badgeClass;
    public string $avatarGrad;
    public array $menuItems = [];

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->user = Auth::user();
        $this->resolvePageTitles();
        $this->resolveUserData();
        $this->resolveMenuItems();
    }

    protected function resolvePageTitles(): void
    {
        $routeTitles = [
            'dashboard'                  => ['Dashboard',        'Ringkasan data posyandu'],
            'admin.analytics'            => ['Analytics',        'Statistik & grafik data'],
            'admin.patients.*'           => ['Data Warga',       'Kelola data pasien posyandu'],
            'admin.posyandu.*'           => ['Data Posyandu',    'Kelola unit posyandu'],
            'admin.schedules.*'          => ['Jadwal Kegiatan',  'Kelola jadwal posyandu'],
            'admin.medical-records.*'    => ['Rekam Medis',      'Data pemeriksaan pasien'],
            'admin.reports.*'            => ['Laporan Bulanan',  'Laporan & ekspor data'],
            'admin.activity-logs.*'      => ['Log Aktivitas',    'Riwayat aktivitas sistem'],
            'admin.articles.*'           => ['Artikel & Berita', 'Kelola konten edukasi'],
            'admin.gallery.*'            => ['Galeri',           'Kelola foto & media'],
            'admin.pedukuhans.*'         => ['Data Pedukuhan',   'Kelola data wilayah'],
            'admin.users.*'              => ['Manajemen User',   'Kelola akun pengguna'],
        ];

        foreach ($routeTitles as $pattern => $labels) {
            if (Route::is($pattern)) {
                [$this->pageTitle, $this->pageSubtitle] = $labels;
                break;
            }
        }
    }

    protected function resolveUserData(): void
    {
        $this->name = $this->user->name ?? 'Admin';
        $this->initials = strtoupper(substr($this->name, 0, 1)) . (str_contains($this->name, ' ') ? strtoupper(substr(strstr($this->name, ' '), 1, 1)) : '');
        
        $this->role = $this->user->role_label;

        $this->badgeClass = match(true) {
            $this->user?->isSuperAdmin() => 'bg-violet-100 text-violet-700',
            $this->user?->isAdmin()      => 'bg-blue-100 text-blue-700',
            $this->user?->isKader()      => 'bg-emerald-100 text-emerald-700',
            default                      => 'bg-slate-100 text-slate-600',
        };

        $this->avatarGrad = match(true) {
            $this->user?->isSuperAdmin() => 'linear-gradient(135deg,#7c3aed 0%,#a78bfa 100%)',
            $this->user?->isAdmin()      => 'linear-gradient(135deg,#1e40af 0%,#3b82f6 100%)',
            $this->user?->isKader()      => 'linear-gradient(135deg,#065f46 0%,#10b981 100%)',
            default                      => 'linear-gradient(135deg,#1e293b 0%,#475569 100%)',
        };
    }

    protected function resolveMenuItems(): void
    {
        $this->menuItems = [
            ['href' => route('dashboard'), 'icon' => 'fa-house', 'label' => 'Dashboard', 'color' => 'emerald'],
            ['href' => route('admin.patients.index'), 'icon' => 'fa-users', 'label' => 'Data Warga', 'color' => 'blue'],
            ['href' => route('admin.schedules.index'), 'icon' => 'fa-calendar-days', 'label' => 'Jadwal', 'color' => 'amber'],
        ];
        
        if ($this->user?->isSuperAdmin() || $this->user?->isAdmin()) {
            $this->menuItems[] = ['href' => route('admin.reports.index'), 'icon' => 'fa-chart-bar', 'label' => 'Laporan Bulanan', 'color' => 'violet'];
        }
        
        if ($this->user?->isSuperAdmin()) {
            $this->menuItems[] = ['href' => route('admin.activity-logs.index'), 'icon' => 'fa-clipboard-list', 'label' => 'Log Aktivitas', 'color' => 'indigo'];
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.app.navbar');
    }
}
