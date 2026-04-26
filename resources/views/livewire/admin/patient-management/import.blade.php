@extends('layouts.app')

@section('title', 'Import Data Warga')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- ── Header ── --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Import Data Warga</h1>
            <p class="text-sm text-slate-500 mt-0.5">Unggah file CSV atau Excel untuk import data massal</p>
        </div>
        <a href="{{ route('admin.patients.index') }}"
           class="flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali
        </a>
    </div>

    {{-- ── Form Card ── --}}
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

        {{-- Header --}}
        <div class="px-6 py-4 border-b border-slate-200 flex items-center gap-3">
            <div class="w-9 h-9 bg-teal-50 rounded-xl flex items-center justify-center text-teal-600">
                <span class="material-symbols-outlined text-[20px]">upload_file</span>
            </div>
            <div>
                <h2 class="text-sm font-bold text-slate-900">Unggah File</h2>
                <p class="text-xs text-slate-400">Format: CSV, XLSX, atau XLS — Maks. 5 MB</p>
            </div>
        </div>

        <form action="{{ route('admin.patients.import.store') }}" method="POST"
              enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf

            @if($errors->any())
            <div class="flex items-start gap-3 px-4 py-3 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm">
                <span class="material-symbols-outlined text-red-500 text-[20px] flex-shrink-0 mt-0.5">error</span>
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Posyandu (superadmin only) --}}
            @if(auth()->user()->isSuperAdmin())
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                    Posyandu Tujuan <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-[18px]">health_and_safety</span>
                    <select name="posyandu_id"
                            class="w-full h-11 pl-10 pr-4 rounded-xl border border-slate-300 text-sm font-medium text-slate-700
                                   focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 transition appearance-none bg-white
                                   @error('posyandu_id') border-red-400 @enderror">
                        <option value="">Pilih Posyandu</option>
                        @foreach($posyandus as $pos)
                            <option value="{{ $pos->id }}" {{ old('posyandu_id') == $pos->id ? 'selected' : '' }}>
                                {{ $pos->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('posyandu_id')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            @else
            <input type="hidden" name="posyandu_id" value="{{ auth()->user()->posyandu_id }}">
            @endif

            {{-- File Upload --}}
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                    File CSV / XLSX <span class="text-red-500">*</span>
                </label>

                {{-- Peringatan XLS --}}
                <div class="mb-3 flex items-start gap-3 px-4 py-3 bg-amber-50 border border-amber-200 rounded-xl text-sm">
                    <span class="material-symbols-outlined text-amber-600 text-[18px] flex-shrink-0 mt-0.5" style="font-variation-settings:'FILL' 1;">warning</span>
                    <div>
                        <p class="font-bold text-amber-800">File .xls tidak didukung</p>
                        <p class="text-amber-700 text-xs mt-0.5">
                            Jika file Anda berformat <strong>.xls</strong> (Excel lama), buka di Excel lalu:
                            <strong>File → Save As → CSV UTF-8 (*.csv)</strong> atau <strong>Excel Workbook (*.xlsx)</strong>
                        </p>
                    </div>
                </div>
                <div id="dropzone"
                     class="relative border-2 border-dashed border-slate-300 rounded-xl p-8 text-center cursor-pointer
                            hover:border-teal-400 hover:bg-teal-50/30 transition-all
                            @error('file') border-red-400 bg-red-50 @enderror"
                     onclick="document.getElementById('fileInput').click()">
                    <input type="file" id="fileInput" name="file" accept=".csv,.xlsx"
                           class="hidden" onchange="handleFileSelect(this)">
                    <div id="dropzoneContent">
                        <span class="material-symbols-outlined text-[40px] text-slate-300 mb-3 block">cloud_upload</span>
                        <p class="text-sm font-semibold text-slate-600">Klik untuk pilih file atau drag & drop</p>
                        <p class="text-xs text-slate-400 mt-1">CSV atau XLSX — Maksimal 5 MB</p>
                        <p class="text-xs text-red-400 mt-1 font-medium">⚠ File .xls tidak didukung, simpan ulang sebagai .csv atau .xlsx</p>
                    </div>
                    <div id="fileSelected" class="hidden">
                        <span class="material-symbols-outlined text-[40px] text-teal-500 mb-3 block" style="font-variation-settings:'FILL' 1;">description</span>
                        <p id="fileName" class="text-sm font-bold text-teal-700"></p>
                        <p id="fileSize" class="text-xs text-slate-400 mt-1"></p>
                        <button type="button" onclick="clearFile(event)"
                                class="mt-2 text-xs text-red-500 hover:underline">Hapus file</button>
                    </div>
                </div>
                @error('file')
                    <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[13px]">error</span>{{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Format Info --}}
            <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-teal-600 text-[18px] flex-shrink-0 mt-0.5">table_chart</span>
                    <div class="w-full">
                        <p class="text-xs font-bold text-slate-700 mb-3">Format Kolom yang Didukung (Format Excel Posyandu):</p>

                        {{-- Kolom Data Warga --}}
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Data Warga</p>
                        <div class="flex flex-wrap gap-1.5 mb-3">
                            @foreach([
                                ['NIK', 'opsional'],
                                ['nama_anak', 'wajib'],
                                ['tgl_lahir', 'wajib'],
                                ['jk', 'L/P'],
                                ['nm_ortu', ''],
                                ['RT', ''],
                                ['RW', ''],
                                ['ALAMAT', ''],
                            ] as [$col, $note])
                            <div class="flex items-center gap-1">
                                <code class="text-[10px] bg-white border border-slate-200 px-1.5 py-0.5 rounded font-mono text-teal-700">{{ $col }}</code>
                                @if($note)
                                <span class="text-[9px] {{ $note === 'wajib' ? 'text-red-500 font-bold' : 'text-slate-400' }}">{{ $note }}</span>
                                @endif
                            </div>
                            @endforeach
                        </div>

                        {{-- Kolom Rekam Medis --}}
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Data Pengukuran (Rekam Medis)</p>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach([
                                ['TANGGAL UKUR', ''],
                                ['BERAT', 'kg'],
                                ['TINGGI', 'cm'],
                                ['LILA', 'cm'],
                                ['lingkar_kepala', 'cm'],
                                ['CARA UKUR', ''],
                                ['vitamin', 'Ya/Tidak'],
                                ['asi_bulan_0', ''],
                                ['Imunisasi', ''],
                            ] as [$col, $note])
                            <div class="flex items-center gap-1">
                                <code class="text-[10px] bg-white border border-slate-200 px-1.5 py-0.5 rounded font-mono text-blue-700">{{ $col }}</code>
                                @if($note)
                                <span class="text-[9px] text-slate-400">{{ $note }}</span>
                                @endif
                            </div>
                            @endforeach
                        </div>

                        <p class="text-[10px] text-slate-400 mt-2.5">
                            <span class="text-red-500 font-bold">*</span> Wajib diisi.
                            Jika NIK tidak ada, sistem akan membuat ID sementara.
                            Data pengukuran akan disimpan sebagai Rekam Medis otomatis.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Download Template --}}
            <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-xl border border-blue-100">
                <span class="material-symbols-outlined text-blue-600 text-[18px]">download</span>
                <p class="text-sm text-blue-800 flex-1">
                    Belum punya template?
                    <a href="{{ route('admin.patients.template') }}"
                       class="font-bold underline hover:text-blue-900">Download template CSV</a>
                    sebagai panduan.
                </p>
            </div>

            {{-- Actions --}}
            <div class="border-t border-slate-100 pt-5 flex items-center justify-between gap-3">
                <a href="{{ route('admin.patients.index') }}"
                   class="h-11 px-6 flex items-center gap-2 rounded-xl border border-slate-300 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-colors">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                    Batal
                </a>
                <button type="submit" id="submitBtn"
                        class="h-11 px-8 bg-teal-600 text-white rounded-xl text-sm font-bold hover:bg-teal-700 active:scale-95
                               transition-all flex items-center gap-2 shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="material-symbols-outlined text-[18px]">upload</span>
                    Mulai Import
                </button>
            </div>
        </form>
    </div>

    {{-- ── Catatan Penting ── --}}
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 flex gap-4">
        <span class="material-symbols-outlined text-amber-600 flex-shrink-0 mt-0.5" style="font-variation-settings:'FILL' 1;">warning</span>
        <div>
            <h4 class="font-bold text-amber-900 text-sm mb-2">Cara Konversi File .xls ke .csv (Wajib Dibaca)</h4>
            <ol class="text-sm text-amber-800/80 space-y-1 list-decimal list-inside mb-3">
                <li>Buka file <strong>.xls</strong> di Microsoft Excel</li>
                <li>Klik <strong>File → Save As</strong></li>
                <li>Pilih format: <strong>"CSV UTF-8 (Comma delimited) (*.csv)"</strong></li>
                <li>Klik <strong>Save</strong> → klik <strong>Yes</strong> jika ada konfirmasi</li>
                <li>Upload file <strong>.csv</strong> yang baru tersimpan</li>
            </ol>
            <p class="text-xs text-amber-700 font-semibold">Atau simpan sebagai <strong>.xlsx</strong> (Excel Workbook) jika ingin tetap dalam format Excel.</p>
        </div>
    </div>

    {{-- ── Catatan Teknis ── --}}
    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 flex gap-4">
        <span class="material-symbols-outlined text-slate-500 flex-shrink-0 mt-0.5">info</span>
        <div>
            <h4 class="font-bold text-slate-700 text-sm mb-1">Catatan Import</h4>
            <ul class="text-sm text-slate-600 space-y-1 list-disc list-inside">
                <li>Kolom NIK <strong>opsional</strong> — jika tidak ada, sistem membuat ID sementara.</li>
                <li>Data pengukuran (BERAT, TINGGI, dll.) otomatis disimpan sebagai <strong>Rekam Medis</strong>.</li>
                <li>Warga yang sudah terdaftar (nama + tanggal lahir sama) akan <strong>diperbarui</strong>.</li>
                <li>Format tanggal: <code class="bg-slate-100 px-1 rounded text-xs">2022-08-06</code>, <code class="bg-slate-100 px-1 rounded text-xs">6 Aug 2022</code>, atau serial Excel.</li>
                <li>Jenis kelamin: <code class="bg-slate-100 px-1 rounded text-xs">L</code> atau <code class="bg-slate-100 px-1 rounded text-xs">P</code>.</li>
            </ul>
        </div>
    </div>

</div>

@push('scripts')
<script>
function handleFileSelect(input) {
    const file = input.files[0];
    if (!file) return;

    document.getElementById('dropzoneContent').classList.add('hidden');
    document.getElementById('fileSelected').classList.remove('hidden');
    document.getElementById('fileName').textContent = file.name;
    document.getElementById('fileSize').textContent = (file.size / 1024).toFixed(1) + ' KB';
}

function clearFile(e) {
    e.stopPropagation();
    document.getElementById('fileInput').value = '';
    document.getElementById('dropzoneContent').classList.remove('hidden');
    document.getElementById('fileSelected').classList.add('hidden');
}

// Drag & drop
const dropzone = document.getElementById('dropzone');
dropzone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropzone.classList.add('border-teal-500', 'bg-teal-50/50');
});
dropzone.addEventListener('dragleave', () => {
    dropzone.classList.remove('border-teal-500', 'bg-teal-50/50');
});
dropzone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzone.classList.remove('border-teal-500', 'bg-teal-50/50');
    const file = e.dataTransfer.files[0];
    if (file) {
        const input = document.getElementById('fileInput');
        const dt = new DataTransfer();
        dt.items.add(file);
        input.files = dt.files;
        handleFileSelect(input);
    }
});

// Loading state on submit
document.querySelector('form').addEventListener('submit', function() {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = `
        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
        </svg>
        Mengimport...
    `;
});
</script>
@endpush
@endsection
