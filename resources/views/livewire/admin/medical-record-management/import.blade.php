{{--
    Import Rekam Medis — Premium UI
    Design: deliberate landing-pad upload zone with animated border pulse,
    live file-type badge, and progress reveal on submit.
--}}

<style>
/* ── Landing-pad upload zone ── */
@keyframes border-march {
    0%   { background-position: 0 0, 100% 0, 100% 100%, 0 100%; }
    100% { background-position: 100% 0, 100% 100%, 0 100%, 0 0; }
}

#drop-zone-inner {
    background-image:
        repeating-linear-gradient(90deg, #059669 0, #059669 8px, transparent 8px, transparent 18px),
        repeating-linear-gradient(180deg, #059669 0, #059669 8px, transparent 8px, transparent 18px),
        repeating-linear-gradient(90deg, #059669 0, #059669 8px, transparent 8px, transparent 18px),
        repeating-linear-gradient(180deg, #059669 0, #059669 8px, transparent 8px, transparent 18px);
    background-size: 26px 2px, 2px 26px, 26px 2px, 2px 26px;
    background-position: 0 0, 100% 0, 100% 100%, 0 100%;
    background-repeat: repeat-x, repeat-y, repeat-x, repeat-y;
    animation: border-march 12s linear infinite;
    transition: background-image 0.3s, background-color 0.3s;
}

#drop-zone-inner.dragging {
    background-color: rgba(5, 150, 105, 0.06);
    background-image:
        repeating-linear-gradient(90deg, #059669 0, #059669 10px, transparent 10px, transparent 16px),
        repeating-linear-gradient(180deg, #059669 0, #059669 10px, transparent 10px, transparent 16px),
        repeating-linear-gradient(90deg, #059669 0, #059669 10px, transparent 10px, transparent 16px),
        repeating-linear-gradient(180deg, #059669 0, #059669 10px, transparent 10px, transparent 16px);
    background-size: 20px 2px, 2px 20px, 20px 2px, 2px 20px;
    animation: border-march 3s linear infinite;
}

#drop-zone-inner.has-file {
    background-color: rgba(5, 150, 105, 0.04);
    background-image:
        repeating-linear-gradient(90deg, #059669 0, #059669 12px, transparent 12px, transparent 16px),
        repeating-linear-gradient(180deg, #059669 0, #059669 12px, transparent 12px, transparent 16px),
        repeating-linear-gradient(90deg, #059669 0, #059669 12px, transparent 12px, transparent 16px),
        repeating-linear-gradient(180deg, #059669 0, #059669 12px, transparent 12px, transparent 16px);
    background-size: 22px 2px, 2px 22px, 22px 2px, 2px 22px;
}

/* ── File type badge colors ── */
.badge-csv  { background: #d1fae5; color: #065f46; }
.badge-xlsx { background: #dbeafe; color: #1e40af; }
.badge-xls  { background: #e0e7ff; color: #3730a3; }

/* ── Progress shimmer ── */
@keyframes shimmer {
    from { background-position: -300px 0; }
    to   { background-position: 300px 0; }
}
.progress-shimmer {
    background: linear-gradient(90deg, #059669 0%, #10b981 50%, #059669 100%);
    background-size: 300px 100%;
    animation: shimmer 1.2s infinite;
}

/* ── Column chip ── */
.col-chip {
    font-family: 'ui-monospace', 'Cascadia Code', 'Fira Code', monospace;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.01em;
    background: #ecfdf5;
    color: #065f46;
    border: 1px solid #a7f3d0;
    padding: 2px 8px;
    border-radius: 6px;
    white-space: nowrap;
    flex-shrink: 0;
}

/* ── Sidebar section label ── */
.sidebar-section-label {
    font-size: 9px;
    font-weight: 900;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: #94a3b8;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.sidebar-section-label::before {
    content: '';
    display: block;
    width: 3px;
    height: 14px;
    border-radius: 2px;
    background: linear-gradient(180deg, #059669, #10b981);
    flex-shrink: 0;
}

/* ── Template pill hover ── */
.tpl-pill { transition: transform 0.18s, box-shadow 0.18s; }
.tpl-pill:hover { transform: translateX(4px); }
</style>

<div class="space-y-7">

    {{-- ── Breadcrumb + Header ── --}}
    <div class="relative">
        {{-- Ambient glow --}}
        <div class="absolute -top-16 -left-16 w-72 h-72 bg-emerald-400/8 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -top-8 right-0 w-48 h-48 bg-cyan-400/6 rounded-full blur-3xl pointer-events-none"></div>

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-1.5 mb-5 relative">
            <a href="{{ route('admin.medical-records.index') }}"
               class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-emerald-600 transition-colors">
                Rekam Medis
            </a>
            <span class="text-slate-300 text-[10px]">/</span>
            <span class="text-[10px] font-black uppercase tracking-widest text-slate-600">Import</span>
        </nav>

        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 relative">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    {{-- Icon badge --}}
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-200">
                        <span class="material-symbols-outlined text-white text-[22px]">upload_file</span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black tracking-tight text-slate-900 leading-tight">
                            Import Rekam Medis
                        </h1>
                        <p class="text-xs font-semibold text-slate-400 mt-0.5">
                            CSV · XLSX · XLS &mdash; hingga 5 MB per file
                        </p>
                    </div>
                </div>
            </div>

            <a href="{{ route('admin.medical-records.index') }}"
               class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-[10px] font-black uppercase tracking-widest text-slate-500 hover:border-emerald-300 hover:text-emerald-600 hover:shadow-sm transition-all self-start sm:self-auto">
                <span class="material-symbols-outlined text-[16px]">chevron_left</span>
                Kembali
            </a>
        </div>
    </div>

    {{-- ── Alerts ── --}}
    @if(session('success'))
    <div id="alert-success" class="relative overflow-hidden rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4">
        <div class="absolute top-0 left-0 bottom-0 w-1 bg-emerald-500 rounded-l-2xl"></div>
        <div class="flex items-start gap-3 pl-3">
            <span class="material-symbols-outlined text-emerald-500 text-[22px] shrink-0 mt-0.5">check_circle</span>
            <div class="flex-1 min-w-0">
                <p class="font-black text-emerald-800 text-sm">{{ session('success') }}</p>
                @if(session('import_errors') && count(session('import_errors')) > 0)
                <details class="mt-2.5">
                    <summary class="text-[10px] font-black uppercase tracking-widest text-emerald-600 cursor-pointer select-none flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">expand_more</span>
                        {{ count(session('import_errors')) }} peringatan baris
                    </summary>
                    <ul class="mt-2 space-y-1 pl-1">
                        @foreach(session('import_errors') as $err)
                        <li class="text-[11px] text-emerald-700 font-semibold flex items-start gap-1.5">
                            <span class="text-emerald-400 shrink-0 mt-0.5">›</span>{{ $err }}
                        </li>
                        @endforeach
                    </ul>
                </details>
                @endif
            </div>
            <button onclick="document.getElementById('alert-success').remove()" class="text-emerald-400 hover:text-emerald-600 shrink-0">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="relative overflow-hidden rounded-2xl border border-red-200 bg-red-50 px-5 py-4">
        <div class="absolute top-0 left-0 bottom-0 w-1 bg-red-500 rounded-l-2xl"></div>
        <div class="flex items-start gap-3 pl-3">
            <span class="material-symbols-outlined text-red-500 text-[22px] shrink-0 mt-0.5">error</span>
            <p class="font-black text-red-800 text-sm">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="relative overflow-hidden rounded-2xl border border-red-200 bg-red-50 px-5 py-4">
        <div class="absolute top-0 left-0 bottom-0 w-1 bg-red-500 rounded-l-2xl"></div>
        <div class="flex items-start gap-3 pl-3">
            <span class="material-symbols-outlined text-red-500 text-[22px] shrink-0 mt-0.5">error</span>
            <ul class="space-y-0.5">
                @foreach($errors->all() as $e)
                <li class="font-bold text-red-800 text-sm">{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    {{-- ── Main layout: form + sidebar ── --}}
    <div class="grid grid-cols-1 xl:grid-cols-[1fr_340px] gap-6 items-start">

        {{-- ── FORM CARD ── --}}
        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">

            {{-- Card header --}}
            <div class="px-8 pt-7 pb-5 border-b border-slate-50 flex items-center justify-between">
                <div>
                    <p class="sidebar-section-label" style="margin-bottom:0">Langkah 1 dari 1</p>
                    <h2 class="text-base font-black text-slate-800 mt-1">Pilih posyandu &amp; unggah file</h2>
                </div>
                {{-- Supported formats chips --}}
                <div class="hidden sm:flex items-center gap-1.5">
                    <span class="badge-csv text-[9px] font-black px-2 py-0.5 rounded-md">.CSV</span>
                    <span class="badge-xlsx text-[9px] font-black px-2 py-0.5 rounded-md">.XLSX</span>
                    <span class="badge-xls text-[9px] font-black px-2 py-0.5 rounded-md">.XLS</span>
                </div>
            </div>

            <form action="{{ route('admin.medical-records.import.store') }}" method="POST"
                  enctype="multipart/form-data" id="import-form" class="px-8 py-7 space-y-7">
                @csrf

                @php $isSuperAdmin = auth()->user()->isSuperAdmin(); @endphp

                {{-- Posyandu selector (superadmin only) --}}
                @if($isSuperAdmin)
                <div>
                    <label for="posyandu_id" class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2.5">
                        Posyandu <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-[20px] pointer-events-none">location_city</span>
                        <select name="posyandu_id" id="posyandu_id"
                            class="w-full h-13 pl-11 pr-10 rounded-xl border {{ $errors->has('posyandu_id') ? 'border-red-300 bg-red-50' : 'border-slate-200 bg-slate-50/60' }} text-sm font-bold text-slate-800 focus:outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 transition-all appearance-none cursor-pointer">
                            <option value="">— Pilih unit posyandu —</option>
                            @foreach($posyandus as $p)
                            <option value="{{ $p->id }}" {{ old('posyandu_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-[18px] pointer-events-none">unfold_more</span>
                    </div>
                    @error('posyandu_id')
                    <p class="mt-1.5 text-[11px] font-bold text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                @else
                <input type="hidden" name="posyandu_id" value="{{ auth()->user()->posyandu_id }}">
                @endif

                {{-- ── UPLOAD ZONE (signature element) ── --}}
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2.5">
                        File Data <span class="text-red-400">*</span>
                    </label>

                    <div id="drop-zone-inner"
                         class="relative rounded-2xl p-8 sm:p-12 text-center cursor-pointer {{ $errors->has('file') ? 'bg-red-50' : '' }}"
                         role="button"
                         aria-label="Area upload file — klik atau tarik file ke sini"
                         tabindex="0"
                         onclick="document.getElementById('file-input').click()"
                         onkeydown="if(event.key==='Enter'||event.key===' ')document.getElementById('file-input').click()"
                         ondragover="event.preventDefault(); this.classList.add('dragging')"
                         ondragleave="this.classList.remove('dragging')"
                         ondrop="handleFileDrop(event)">

                        <input type="file" name="file" id="file-input"
                               accept=".csv,.xlsx,.xls" class="sr-only"
                               onchange="handleFileSelect(this)">

                        {{-- State: idle --}}
                        <div id="state-idle">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-100 to-teal-50 flex items-center justify-center mx-auto mb-5 ring-2 ring-emerald-200/50">
                                <span class="material-symbols-outlined text-emerald-600 text-[28px]">cloud_upload</span>
                            </div>
                            <p class="font-black text-slate-700 text-[17px] leading-tight">Tarik file ke sini</p>
                            <p class="text-[12px] font-semibold text-slate-400 mt-1.5">atau <span class="text-emerald-600 font-black underline decoration-dotted underline-offset-2">klik untuk memilih</span></p>
                            <div class="flex items-center justify-center gap-2 mt-5">
                                <span class="badge-csv text-[9px] font-black px-2 py-0.5 rounded-md">.CSV</span>
                                <span class="badge-xlsx text-[9px] font-black px-2 py-0.5 rounded-md">.XLSX</span>
                                <span class="badge-xls text-[9px] font-black px-2 py-0.5 rounded-md">.XLS</span>
                                <span class="text-[9px] font-black text-slate-300 ml-1">maks 5 MB</span>
                            </div>
                        </div>

                        {{-- State: file selected --}}
                        <div id="state-selected" class="hidden">
                            <div class="inline-flex items-center gap-4 bg-white rounded-2xl px-6 py-4 shadow-sm border border-emerald-100">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0" id="file-icon-wrap">
                                    <span class="material-symbols-outlined text-emerald-500 text-[28px]">description</span>
                                </div>
                                <div class="text-left min-w-0">
                                    <p id="file-name" class="font-black text-slate-800 text-sm truncate max-w-[220px]"></p>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span id="file-ext-badge" class="text-[9px] font-black px-2 py-0.5 rounded-md"></span>
                                        <span id="file-size" class="text-[11px] font-bold text-slate-400"></span>
                                    </div>
                                </div>
                                <div class="shrink-0 ml-2">
                                    <span class="w-7 h-7 flex items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                                        <span class="material-symbols-outlined text-[16px]">check</span>
                                    </span>
                                </div>
                            </div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mt-4">
                                Klik untuk mengganti file
                            </p>
                        </div>

                        {{-- State: dragging overlay label --}}
                        <div id="state-dragging" class="hidden absolute inset-0 rounded-2xl flex items-center justify-center pointer-events-none">
                            <div class="flex flex-col items-center gap-2">
                                <span class="material-symbols-outlined text-emerald-500 text-[40px]">file_download</span>
                                <p class="font-black text-emerald-700 text-sm">Lepaskan file di sini</p>
                            </div>
                        </div>
                    </div>

                    @error('file')
                    <p class="mt-2 text-[11px] font-bold text-red-500 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">error</span>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- ── Progress bar (hidden until submit) ── --}}
                <div id="progress-wrap" class="hidden">
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Memproses file…</span>
                        <span class="text-[10px] font-black text-emerald-600" id="progress-label">Mohon tunggu</span>
                    </div>
                    <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="progress-shimmer h-full w-full rounded-full"></div>
                    </div>
                    <p class="text-[10px] font-semibold text-slate-400 mt-2">
                        Jangan tutup halaman ini selama proses berjalan.
                    </p>
                </div>

                {{-- ── Actions ── --}}
                <div class="flex items-center gap-3 pt-1 border-t border-slate-50">
                    <button type="submit" id="submit-btn"
                        class="flex items-center gap-2 px-7 py-3.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-[11px] font-black uppercase tracking-widest shadow-md shadow-emerald-200 hover:shadow-emerald-300 hover:-translate-y-px active:translate-y-0 transition-all disabled:opacity-60 disabled:cursor-not-allowed disabled:translate-y-0">
                        <span class="material-symbols-outlined text-[18px]" id="submit-icon">upload</span>
                        <span id="submit-label">Jalankan Import</span>
                    </button>
                    <a href="{{ route('admin.medical-records.index') }}"
                       class="flex items-center gap-1.5 px-5 py-3.5 rounded-xl border border-slate-200 text-[11px] font-black uppercase tracking-widest text-slate-500 hover:border-slate-300 hover:bg-slate-50 transition-all">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        {{-- ── SIDEBAR ── --}}
        <div class="space-y-5">

            {{-- Template download --}}
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6">
                <p class="sidebar-section-label">Template CSV</p>
                <p class="text-[11px] font-semibold text-slate-500 mb-4 leading-relaxed">
                    Unduh template sesuai kategori warga, lalu isi datanya sebelum diimpor.
                </p>
                <div class="space-y-2">
                    <a href="{{ route('admin.medical-records.template', ['category' => 'balita']) }}"
                       class="tpl-pill w-full flex items-center gap-3 px-4 py-3 rounded-xl border border-blue-100 bg-blue-50/70 hover:bg-blue-100/70 text-blue-800 transition-all">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-blue-600 text-[18px]">child_care</span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-[12px] font-black">Balita / Bayi / Anak</p>
                            <p class="text-[9px] font-bold text-blue-400 font-mono">template_balita.csv</p>
                        </div>
                        <span class="material-symbols-outlined text-[16px] text-blue-300 shrink-0">download</span>
                    </a>

                    <a href="{{ route('admin.medical-records.template', ['category' => 'ibu_hamil']) }}"
                       class="tpl-pill w-full flex items-center gap-3 px-4 py-3 rounded-xl border border-rose-100 bg-rose-50/70 hover:bg-rose-100/70 text-rose-800 transition-all">
                        <div class="w-8 h-8 rounded-lg bg-rose-100 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-rose-500 text-[18px]">pregnant_woman</span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-[12px] font-black">Ibu Hamil</p>
                            <p class="text-[9px] font-bold text-rose-400 font-mono">template_ibu_hamil.csv</p>
                        </div>
                        <span class="material-symbols-outlined text-[16px] text-rose-300 shrink-0">download</span>
                    </a>

                    <a href="{{ route('admin.medical-records.template', ['category' => 'lansia']) }}"
                       class="tpl-pill w-full flex items-center gap-3 px-4 py-3 rounded-xl border border-violet-100 bg-violet-50/70 hover:bg-violet-100/70 text-violet-800 transition-all">
                        <div class="w-8 h-8 rounded-lg bg-violet-100 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-violet-500 text-[18px]">elderly</span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-[12px] font-black">Lansia</p>
                            <p class="text-[9px] font-bold text-violet-400 font-mono">template_lansia.csv</p>
                        </div>
                        <span class="material-symbols-outlined text-[16px] text-violet-300 shrink-0">download</span>
                    </a>
                </div>
            </div>

            {{-- Kolom yang dikenali --}}
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6">
                <p class="sidebar-section-label">Kolom yang dikenali</p>
                <div class="space-y-2">
                    @foreach([
                        ['NIK / nik',         'NIK 16 digit'],
                        ['nama_anak / nama',   'Nama lengkap'],
                        ['tgl_lahir',          'Tgl lahir (YYYY-MM-DD)'],
                        ['jk',                 'L atau P'],
                        ['nm_ortu / suami',    'Nama orang tua'],
                        ['TANGGAL UKUR',       'Tgl kunjungan'],
                        ['BERAT',              'Berat badan (kg)'],
                        ['TINGGI',             'Tinggi badan (cm)'],
                        ['lingkar_kepala',     'Lingkar kepala (cm)'],
                        ['vitamin',            'Vitamin A (Ya/Tidak)'],
                        ['Imunisasi',          'Jenis imunisasi'],
                    ] as [$col, $desc])
                    <div class="flex items-center gap-2.5">
                        <code class="col-chip">{{ $col }}</code>
                        <span class="text-[11px] font-semibold text-slate-500">{{ $desc }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Aturan import --}}
            <div class="rounded-[2rem] border border-amber-200 bg-amber-50/80 p-6">
                <p class="sidebar-section-label" style="--tw-text-opacity:1;color:#b45309">
                    Aturan import
                </p>
                <ul class="space-y-2.5 text-[11px] font-semibold text-amber-800 leading-relaxed">
                    <li class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-amber-400 text-[15px] mt-0.5 shrink-0">person_check</span>
                        Warga yang sudah ada akan <strong>diperbarui</strong>, bukan diduplikasi.
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-amber-400 text-[15px] mt-0.5 shrink-0">event_busy</span>
                        Rekam medis di tanggal yang sama akan <strong>dilewati</strong>.
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-amber-400 text-[15px] mt-0.5 shrink-0">badge</span>
                        NIK kosong atau tidak valid → sistem buat <strong>NIK sementara</strong>.
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-amber-400 text-[15px] mt-0.5 shrink-0">calendar_today</span>
                        Format tanggal: <code class="col-chip">YYYY-MM-DD</code> atau serial Excel.
                    </li>
                </ul>
            </div>

        </div>
    </div>
</div>

<script>
(function () {
    var dropZone   = document.getElementById('drop-zone-inner');
    var fileInput  = document.getElementById('file-input');
    var stateIdle  = document.getElementById('state-idle');
    var stateSel   = document.getElementById('state-selected');
    var stateDrag  = document.getElementById('state-dragging');
    var form       = document.getElementById('import-form');
    var submitBtn  = document.getElementById('submit-btn');
    var submitIcon = document.getElementById('submit-icon');
    var submitLbl  = document.getElementById('submit-label');
    var progressW  = document.getElementById('progress-wrap');

    var extBadgeMap = {
        csv:  { cls: 'badge-csv',  label: '.CSV'  },
        xlsx: { cls: 'badge-xlsx', label: '.XLSX' },
        xls:  { cls: 'badge-xls',  label: '.XLS'  },
    };

    function showFile(file) {
        var ext = file.name.split('.').pop().toLowerCase();
        var badge = extBadgeMap[ext] || { cls: 'badge-csv', label: '.' + ext.toUpperCase() };
        var sizeMb = (file.size / 1024 / 1024).toFixed(2);

        document.getElementById('file-name').textContent  = file.name;
        document.getElementById('file-size').textContent  = sizeMb + ' MB';

        var extEl = document.getElementById('file-ext-badge');
        extEl.textContent  = badge.label;
        extEl.className    = badge.cls + ' text-[9px] font-black px-2 py-0.5 rounded-md';

        stateIdle.classList.add('hidden');
        stateSel.classList.remove('hidden');
        dropZone.classList.add('has-file');
    }

    window.handleFileSelect = function (input) {
        if (input.files && input.files[0]) showFile(input.files[0]);
    };

    window.handleFileDrop = function (event) {
        event.preventDefault();
        dropZone.classList.remove('dragging');
        stateDrag.classList.add('hidden');
        stateIdle.classList.remove('hidden');

        var file = event.dataTransfer.files[0];
        if (!file) return;

        var ext = file.name.split('.').pop().toLowerCase();
        if (!['csv', 'xlsx', 'xls'].includes(ext)) {
            alert('Format tidak didukung. Gunakan CSV, XLSX, atau XLS.');
            return;
        }

        var dt = new DataTransfer();
        dt.items.add(file);
        fileInput.files = dt.files;
        showFile(file);
    };

    // Drag visual feedback
    dropZone.addEventListener('dragover', function () {
        stateDrag.classList.remove('hidden');
    });
    dropZone.addEventListener('dragleave', function () {
        stateDrag.classList.add('hidden');
    });

    // Submit loading state
    form.addEventListener('submit', function () {
        submitBtn.disabled = true;
        submitIcon.textContent = 'progress_activity';
        submitIcon.style.animation = 'spin 1s linear infinite';
        submitLbl.textContent = 'Memproses…';
        progressW.classList.remove('hidden');
    });

    // Spin keyframe injected via style
    var s = document.createElement('style');
    s.textContent = '@keyframes spin{to{transform:rotate(360deg)}}';
    document.head.appendChild(s);
})();
</script>
