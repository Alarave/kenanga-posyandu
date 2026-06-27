@extends('layouts.admin-layout')

@section('admin-title')
@endsection

@section('admin-content')
    @php
        $cat = $patient->category;
        $theme = match ($cat) {
            'bayi', 'baduta', 'balita' => [
                'name' => 'Balita',
                'gradient' => 'from-teal-600 to-emerald-500',
                'shadow' => 'shadow-teal-500/10',
                'border' => 'border-teal-100',
                'bg-light' => 'bg-primary-container',
                'text' => 'text-primary',
                'text-hover' => 'hover:text-primary',
                'border-hover' => 'hover:border-primary',
                'partial' => 'balita',
                'avatar_icon' => 'child_care',
            ],
            'lansia' => [
                'name' => 'Lansia',
                'gradient' => 'from-amber-600 to-orange-500',
                'shadow' => 'shadow-amber-500/10',
                'border' => 'border-amber-100',
                'bg-light' => 'bg-amber-50',
                'text' => 'text-amber-600',
                'text-hover' => 'hover:text-amber-600',
                'border-hover' => 'hover:border-amber-200',
                'partial' => 'lansia',
                'avatar_icon' => 'elderly',
            ],
            'ibu_hamil' => [
                'name' => 'Ibu Hamil',
                'gradient' => 'from-rose-500 to-pink-500',
                'shadow' => 'shadow-rose-500/10',
                'border' => 'border-rose-100',
                'bg-light' => 'bg-error-container',
                'text' => 'text-error',
                'text-hover' => 'hover:text-error',
                'border-hover' => 'hover:border-error',
                'partial' => 'ibu_hamil',
                'avatar_icon' => 'pregnant_woman',
            ],
            default => [
                'name' => str_replace('_', ' ', ucfirst($cat)),
                'gradient' => 'from-indigo-600 to-slate-500',
                'shadow' => 'shadow-indigo-500/10',
                'border' => 'border-indigo-100',
                'bg-light' => 'bg-secondary-container',
                'text' => 'text-secondary',
                'text-hover' => 'hover:text-secondary',
                'border-hover' => 'hover:border-secondary',
                'partial' => 'umum',
                'avatar_icon' => 'account_circle',
            ],
        };
    @endphp
    <div class="max-w-5xl mx-auto space-y-8 pb-10">

        {{-- ── Section 2: Data Medis & Sosial (Full Width) ── --}}
        <div class="w-full">
            @include('livewire.admin.patient-management.details.' . $theme['partial'])
        </div>

        {{-- Growth Chart (Full Width) ── --}}
        <div class="w-full mt-10 pb-16">
            @livewire('admin.patient-management.growth-chart', ['patient' => $patient, 'isEmbedded' => true])
        </div>

    </div>
@endsection
