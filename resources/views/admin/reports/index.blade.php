@extends('layouts.app')

@section('title', 'Laporan Bulanan')

@section('content')

{{-- Page Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-slate-900">Laporan Bulanan</h1>
        <p class="text-sm text-slate-500 mt-0.5">Rekap data kunjungan dan kesehatan posyandu</p>
    </div>
    <div class="flex items-center gap-2 text-xs text-slate-400">
        <i class="fas fa-home"></i>
        <span>Dashboard</span>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <span class="text-slate-600 font-medium">Laporan Bulanan</span>
    </div>
</div>

{{-- Livewire Component --}}
@livewire('admin.reports.monthly-report')

@endsection

@push('scripts')
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
@endpush
