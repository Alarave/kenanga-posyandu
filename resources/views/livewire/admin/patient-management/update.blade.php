@extends('layouts.admin-layout')
 
@section('admin-title') @endsection
 
@section('admin-content')
@php
    $currentCategory = old('category', $patient->category);
@endphp
<div class="w-full space-y-10 pb-24" 
     x-data="{ 
        category: '{{ old('category', $patient->category) }}',
        nikCount: {{ strlen(old('id_number', $patient->id_number)) }},
        gender: '{{ old('gender', $patient->gender) }}',
        init() {
            this.$watch('category', value => {
                if (value === 'ibu_hamil') {
                    this.gender = 'F';
                }
            });
        }
     }">
 
    <div class="flex items-center justify-between px-4">
        <div class="bg-white/80 backdrop-blur-md px-8 py-4 rounded-2xl border border-white shadow-sm flex items-center gap-4">
            <div class="w-2 h-2 bg-primary rounded-lg animate-pulse"></div>
            <h2 class="text-headline-sm font-black text-on-surface tracking-tight">Perbarui Data Warga</h2>
        </div>
        <x-button href="{{ route('admin.patients.index') }}" variant="ghost" class="bg-white! border border-outline-variant rounded-2xl! px-6! h-14 font-black">
            <span class="material-symbols-outlined mr-2 text-[24px]">arrow_back</span> Kembali
        </x-button>
    </div>
 
    {{-- Error Alert --}}
    @if ($errors->any())
        <div class="bg-red-50 border-2 border-red-100 rounded-[2.5rem] p-8 animate-in fade-in slide-in-from-top-4 duration-500 mx-4">
            <div class="flex gap-4 items-center mb-4">
                <div class="w-10 h-10 rounded-xl bg-red-500 text-white flex items-center justify-center shadow-lg shadow-red-200">
                    <span class="material-symbols-outlined">error</span>
                </div>
                <div>
                    <h4 class="text-sm font-black text-red-800 uppercase tracking-widest">Validasi Data Gagal</h4>
                    <p class="text-xs font-bold text-red-500 mt-0.5">Silakan periksa kembali beberapa inputan berikut:</p>
                </div>
            </div>
            <ul class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2">
                @foreach ($errors->all() as $error)
                    <li class="text-xs font-bold text-error flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-red-400 rounded-lg"></span>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
 
    <form action="{{ route('admin.patients.update', $patient->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-8 px-4">
        @csrf
        @method('PUT')
        <input type="hidden" name="category" x-model="category">
        <input type="hidden" name="is_pregnant" value="1" x-bind:disabled="category !== 'ibu_hamil'">
 
        {{-- Include Shared Form Fields --}}
        @include('livewire.admin.patient-management.partials.form-fields', ['patient' => $patient])

        {{-- ── Action Buttons ── --}}
        <div class="w-full mt-8">
            <div class="flex items-center justify-between bg-white/50 backdrop-blur-md p-6 rounded-[2.5rem] border border-white shadow-xl">
                <p class="text-[10px] font-bold text-outline-variant px-6 uppercase tracking-widest hidden md:block">Pastikan seluruh data yang bertanda <span class="text-teal-500 font-black">*</span> telah terisi dengan benar.</p>
                <div class="flex items-center gap-4 ml-auto">
                    <x-button href="{{ route('admin.patients.index') }}" variant="ghost" class="rounded-2xl! h-14 px-8! font-black text-outline-variant">Batal</x-button>
                    <x-button type="submit" variant="primary" class="rounded-2xl! h-14 px-10! shadow-lg shadow-teal-500/30 font-black">
                        <span class="material-symbols-outlined mr-2">save</span> Simpan Perubahan
                    </x-button>
                </div>
            </div>
        </div>
    </form>
</div>
 
@push('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('photo-preview');
        const placeholder = document.getElementById('photo-placeholder');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection