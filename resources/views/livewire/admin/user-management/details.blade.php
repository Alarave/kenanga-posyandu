@extends('layouts.admin-layout')

@section('admin-title', 'Detail Pengguna: ' . $user->name)

@section('admin-content')
<div class="max-w-5xl mx-auto">
    <!-- Header Section -->
    <div class="mb-10 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
        <div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight mb-2">Profil Pengguna</h2>
            <p class="text-slate-500 font-medium">Informasi mendalam mengenai akun <span class="text-indigo-600 font-bold">{{ $user->name }}</span>.</p>
        </div>
        <div class="flex items-center space-x-3 shrink-0">
            <a href="{{ route('admin.users.index') }}" class="w-12 h-12 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:border-indigo-100 hover:bg-indigo-50 transition-all shadow-sm shrink-0">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <a href="{{ route('admin.users.edit', $user) }}" class="flex items-center justify-center px-6 md:px-8 py-3.5 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-500/20 active:scale-95 whitespace-nowrap shrink-0">
                <i class="fas fa-pencil-alt mr-2"></i> EDIT PROFIL
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left: Profile Brief -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white rounded-[2.5rem] p-8 shadow-2xl shadow-slate-200/60 border border-slate-50 text-center relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50/50 rounded-full blur-2xl -mr-16 -mt-16 group-hover:bg-indigo-100/50 transition-colors"></div>
                
                <div class="relative">
                    <div class="w-32 h-32 mx-auto rounded-[2rem] bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-white text-4xl font-black shadow-2xl shadow-indigo-200 mb-6 group-hover:scale-105 transition-transform">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <h3 class="text-xl font-black text-slate-800 tracking-tight">{{ $user->name }}</h3>
                    <p class="text-slate-400 font-bold text-[10px] uppercase tracking-[0.2em] mt-2 italic">@ {{ $user->username }}</p>
                    
                    <div class="mt-6">
                        @php
                            $roleKey = $user->display_role_name;
                            $roles = [
                                'admin_rw' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-600'],
                                'admin1' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-600'],
                                'admin2' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-600'],
                                'kader1' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-600'],
                                'kader2' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-600'],
                            ];
                            $r = $roles[$roleKey] ?? ['bg' => 'bg-slate-100', 'text' => 'text-slate-600'];
                        @endphp
                        <span class="px-6 py-2 {{ $r['bg'] }} {{ $r['text'] }} text-[10px] font-black rounded-full uppercase tracking-widest shadow-sm">
                            {{ $user->role_label }}
                        </span>
                    </div>

                    <div class="mt-10 pt-8 border-t border-slate-50 grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-1">Status</p>
                            @if($user->is_active)
                                <p class="text-emerald-500 font-black text-xs uppercase tracking-widest">AKTIF</p>
                            @else
                                <p class="text-rose-500 font-black text-xs uppercase tracking-widest">NON-AKTIF</p>
                            @endif
                        </div>
                        <div class="text-center">
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-1">Bergabung</p>
                            <p class="text-slate-600 font-black text-xs uppercase tracking-widest">{{ $user->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Detailed Info -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Account Info -->
            <div class="bg-white rounded-[2.5rem] p-10 shadow-2xl shadow-slate-200/60 border border-slate-50 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50/50 rounded-full blur-3xl -mr-32 -mt-32"></div>
                
                <div class="relative space-y-10">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest">Informasi Dasar</h4>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-12">
                        <div>
                            <label class="text-[10px] font-black text-slate-300 uppercase tracking-widest block mb-2">Nama Lengkap</label>
                            <p class="text-slate-700 font-bold tracking-tight">{{ $user->name }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-300 uppercase tracking-widest block mb-2">Alamat Email</label>
                            <p class="text-slate-700 font-bold tracking-tight">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-300 uppercase tracking-widest block mb-2">Username</label>
                            <p class="text-indigo-600 font-black tracking-tight tracking-widest">@ {{ $user->username }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-300 uppercase tracking-widest block mb-2">Peran Akun</label>
                            <p class="text-slate-700 font-bold tracking-tight">{{ $user->role_label }} System</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity / System Info -->
            <div class="bg-white rounded-[2.5rem] p-10 shadow-2xl shadow-slate-200/60 border border-slate-50 relative overflow-hidden">
                <div class="relative space-y-10">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
                            <i class="fas fa-history"></i>
                        </div>
                        <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest">Aktivitas Sistem</h4>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-12">
                        <div>
                            <label class="text-[10px] font-black text-slate-300 uppercase tracking-widest block mb-2">Terdaftar Sejak</label>
                            <p class="text-slate-700 font-bold tracking-tight">{{ $user->created_at->format('d F Y, H:i') }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-300 uppercase tracking-widest block mb-2">Pembaruan Terakhir</label>
                            <p class="text-slate-700 font-bold tracking-tight">{{ $user->updated_at->format('d F Y, H:i') }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-300 uppercase tracking-widest block mb-2">Status Verifikasi</label>
                            @if($user->email_verified_at)
                                <div class="flex items-center text-emerald-500 font-bold text-xs uppercase tracking-widest">
                                    <i class="fas fa-check-circle mr-2"></i> DATA TERVERIFIKASI
                                </div>
                            @else
                                <div class="flex items-center text-rose-500 font-bold text-xs uppercase tracking-widest">
                                    <i class="fas fa-times-circle mr-2"></i> BELUM VERIFIKASI
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
