@extends('layouts.admin-layout')

@section('admin-title')
    Detail Pedukuhan: {{ $pedukuhan->name }}
@endsection

@section('admin-actions')
    <div class="flex gap-2">
        <a href="{{ route('admin.pedukuhans.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-200 bg-white text-gray-600 font-bold text-sm shadow-sm transition-all hover:bg-gray-50">
            <span class="material-symbols-outlined" style="font-size:18px;">arrow_back</span>
            Kembali
        </a>
        <a href="{{ route('admin.pedukuhans.edit', $pedukuhan->id) }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-white font-bold text-sm shadow-sm transition-all bg-slate-900 hover:bg-slate-800">
            <span class="material-symbols-outlined" style="font-size:18px;">edit</span>
            Edit Pedukuhan
        </a>
    </div>
@endsection

@section('admin-content')
<div class="space-y-6">
    {{-- Main Info Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Card: Detail Pedukuhan --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between" style="background:#F8FAFC;">
                <h3 class="font-bold text-gray-900 flex items-center gap-2" style="font-size:16px;">
                    <span class="material-symbols-outlined text-slate-600">map</span>
                    Informasi Wilayah
                </h3>
            </div>
            
            <div class="p-6 space-y-6">
                <div>
                    <h1 class="text-2xl font-black text-gray-900 mb-2">{{ $pedukuhan->name }}</h1>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        {{ $pedukuhan->description ?: 'Tidak ada deskripsi tambahan untuk wilayah ini.' }}
                    </p>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-6 border-t border-gray-50">
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined">straighten</span>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Luas Wilayah</p>
                                <p class="text-lg font-black text-gray-900">{{ $pedukuhan->area ?? '0' }} <span class="text-xs font-bold text-gray-400">km²</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined">groups</span>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Estimasi Penduduk</p>
                                <p class="text-lg font-black text-gray-900">{{ number_format($pedukuhan->population ?? 0) }} <span class="text-xs font-bold text-gray-400">Jiwa</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar Stats --}}
        <div class="space-y-5">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h4 class="font-bold text-gray-900 mb-4 text-sm">Statistik Terintegrasi</h4>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 border border-gray-100">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-blue-500">house_medical</span>
                            <span class="text-xs font-bold text-gray-600">Unit Posyandu</span>
                        </div>
                        <span class="font-black text-gray-900">{{ $pedukuhan->posyandus()->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 border border-gray-100">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-emerald-500">person</span>
                            <span class="text-xs font-bold text-gray-600">Pasien Terdaftar</span>
                        </div>
                        <span class="font-black text-gray-900">{{ $pedukuhan->patients()->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Posyandu List in this Pedukuhan --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between" style="background:#F8FAFC;">
            <h3 class="font-bold text-gray-900" style="font-size:16px;">Unit Posyandu di Wilayah Ini</h3>
            <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-black uppercase tracking-wider">
                Total: {{ $pedukuhan->posyandus->count() }}
            </span>
        </div>
        
        <div class="overflow-x-auto">
            @if($pedukuhan->posyandus->isNotEmpty())
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    <tr>
                        <th class="px-6 py-4 text-left">Nama Posyandu</th>
                        <th class="px-6 py-4 text-left">Kode Unik</th>
                        <th class="px-6 py-4 text-left">Alamat</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach($pedukuhan->posyandus as $posyandu)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-bold text-gray-900">
                            {{ $posyandu->name }}
                        </td>
                        <td class="px-6 py-4">
                            <code class="px-2 py-1 bg-gray-100 rounded text-xs font-bold text-gray-600">{{ $posyandu->unique_code ?: '-' }}</code>
                        </td>
                        <td class="px-6 py-4 text-gray-500 max-w-xs truncate">
                            {{ $posyandu->address ?: '-' }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.posyandu.show', $posyandu->id) }}" 
                               class="text-blue-600 hover:text-blue-800 text-xs font-bold transition">Lihat Unit →</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="px-6 py-16 text-center">
                <span class="material-symbols-outlined text-gray-200 block mb-2" style="font-size:48px;">house_medical_off</span>
                <p class="text-sm font-semibold text-gray-400">Belum ada unit posyandu yang terdaftar di wilayah ini.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
