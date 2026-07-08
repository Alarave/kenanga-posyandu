<div class="space-y-6">
    {{-- Header Section --}}
    <div class="relative mb-10">
        <div class="absolute -top-10 -left-10 w-64 h-64 bg-teal-500/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 relative">
            <div class="space-y-2">
                <div class="flex items-start gap-4">
                    <div class="w-1.5 h-12 bg-gradient-to-b from-teal-500 to-emerald-400 rounded-full mt-1 hidden sm:block"></div>
                    <div>
                        <h1 class="text-3xl font-black tracking-tight leading-none text-transparent bg-clip-text bg-gradient-to-r from-teal-600 to-emerald-500">
                            Import Rekam Medis
                        </h1>
                        <p class="text-sm font-bold text-slate-500 mt-2">
                            Upload file CSV atau Excel untuk mengimpor data rekam medis secara massal.
                        </p>
                    </div>
                </div>
            </div>

            <a href="{{ route('admin.medical-records.index') }}"
               class="flex items-center gap-2 px-5 py-3 rounded-2xl bg-white border border-slate-100 text-xs font-black uppercase tracking-widest text-slate-500 hover:text-teal-600 hover:border-teal-200 hover:shadow-lg hover:shadow-teal-500/5 transition-all">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Kembali
            </a>
        </div>
    </div>

    {{-- Alert: Success --}}
    @if(session('success'))
    <div class="flex items-start gap-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl px-6 py-4">
        <span class="material-symbols-outlined text-emerald-500 text-[24px] mt-0.5 shrink-0">check_circle</span>
        <div class="flex-1">
            <p class="font-black text-sm">{{ session('success') }}</p>
            @if(session('import_errors') && count(session('import_errors')) > 0)
            <details class="mt-3">
                <summary class="text-xs font-black uppercase tracking-widest text-emerald-700 cursor-pointer hover:underline">
                    Lihat {{ count(session('import_errors')) }} peringatan
                </summary>
                <ul class="mt-2 space-y-1">
                    @foreach(session('import_errors') as $err)
                    <li class="text-xs text-emerald-700 font-semibold flex items-start gap-2">
                        <span class="material-symbols-outlined text-[14px] mt-0.5 shrink-0">warning</span>
                        {{ $err }}
                    </li>
                    @endforeach
                </ul>
            </details>
            @endif
        </div>
    </div>
    @endif

    {{-- Alert: Error --}}
    @if(session('error'))
    <div class="flex items-start gap-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl px-6 py-4">
        <span class="material-symbols-outlined text-red-500 text-[24px] mt-0.5 shrink-0">error</span>
        <p class="font-black text-sm">{{ session('error') }}</p>
    </div>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
    <div class="flex items-start gap-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl px-6 py-4">
        <span class="material-symbols-outlined text-red-500 text-[24px] mt-0.5 shrink-0">error</span>
        <ul class="space-y-1">
            @foreach($errors->all() as $error)
            <li class="font-bold text-sm">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Form Card --}}
        <div class="lg:col-span-2">
            <div class="bg-white border border-slate-100 rounded-[2.5rem] shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-50">
                    <h2 class="text-sm font-black uppercase tracking-widest text-slate-700 flex items-center gap-2">
                        <span class="material-symbols-outlined text-teal-500 text-[20px]">upload_file</span>
                        Upload File
                    </h2>
                </div>

                <form action="{{ route('admin.medical-records.import.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6" id="import-form">
                    @csrf

                    @php $isSuperAdmin = auth()->user()->isSuperAdmin(); @endphp

                    @if($isSuperAdmin)
                    <div>
                        <label for="posyandu_id" class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">
                            Posyandu <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-[20px] pointer-events-none">home_health</span>
                            <select name="posyandu_id" id="posyandu_id"
                                class="w-full h-14 pl-11 pr-10 rounded-2xl border border-slate-200 bg-slate-50/50 text-sm font-bold text-slate-800 focus:outline-none focus:border-teal-400 focus:ring-2 focus:ring-teal-100 transition-all appearance-none @error('posyandu_id') border-red-300 bg-red-50 @enderror">
                                <option value="">-- Pilih Posyandu --</option>
                                @foreach($posyandus as $p)
                                <option value="{{ $p->id }}" {{ old('posyandu_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                @endforeach
                            </select>
                            <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-[18px] pointer-events-none">expand_more</span>
                        </div>
                        @error('posyandu_id')
                        <p class="mt-1 text-xs font-bold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    @else
                    <input type="hidden" name="posyandu_id" value="{{ auth()->user()->posyandu_id }}">
                    @endif

                    {{-- Drag & Drop Upload Zone --}}
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">
                            File Import <span class="text-red-500">*</span>
                        </label>

                        <div id="drop-zone"
                             class="relative border-2 border-dashed border-slate-200 rounded-3xl p-10 text-center cursor-pointer transition-all duration-300 hover:border-teal-400 hover:bg-teal-50/30 group @error('file') border-red-300 bg-red-50/20 @enderror"
                             onclick="document.getElementById('file-input').click()"
                             ondragover="event.preventDefault(); this.classList.add('border-teal-400','bg-teal-50/30')"
                             ondragleave="this.classList.remove('border-teal-400','bg-teal-50/30')"
                             ondrop="handleDrop(event)">

                            <input type="file" name="file" id="file-input" accept=".csv,.xlsx,.xls" class="hidden"
                                   onchange="handleFileSelect(this)">

                            <div id="drop-default">
                                <div class="w-16 h-16 rounded-2xl bg-teal-50 flex items-center justify-center mx-auto mb-4 group-hover:bg-teal-100 transition-colors">
                                    <span class="material-symbols-outlined text-teal-500 text-[32px]">cloud_upload</span>
                                </div>
                                <p class="font-black text-slate-700 text-base">Drag & drop file di sini</p>
                                <p class="text-xs font-bold text-slate-400 mt-1">atau klik untuk memilih file</p>
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-300 mt-3">CSV &middot; XLSX &middot; XLS &middot; Maks 5 MB</p>
                            </div>

                            <div id="drop-selected" class="hidden">
                                <div class="w-16 h-16 rounded-2xl bg-emerald-50 flex items-center justify-center mx-auto mb-4">
                                    <span class="material-symbols-outlined text-emerald-500 text-[32px]">description</span>
                                </div>
                                <p id="file-name" class="font-black text-slate-800 text-base"></p>
                                <p id="file-size" class="text-xs font-bold text-slate-400 mt-1"></p>
                                <p class="text-[10px] font-black uppercase tracking-widest text-teal-500 mt-3">Klik untuk mengganti file</p>
                            </div>
                        </div>

                        @error('file')
                        <p class="mt-2 text-xs font-bold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit" id="submit-btn"
                            class="flex items-center gap-2 px-8 py-4 rounded-2xl bg-gradient-to-br from-teal-600 to-emerald-500 text-white text-xs font-black uppercase tracking-widest shadow-xl shadow-teal-200 hover:shadow-teal-300 hover:-translate-y-0.5 transition-all">
                            <span class="material-symbols-outlined text-[20px]">upload</span>
                            Mulai Import
                        </button>
                        <a href="{{ route('admin.medical-records.index') }}"
                           class="flex items-center gap-2 px-6 py-4 rounded-2xl bg-white border border-slate-200 text-xs font-black uppercase tracking-widest text-slate-500 hover:border-slate-300 transition-all">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-4">
            {{-- Download Template --}}
            <div class="bg-white border border-slate-100 rounded-[2rem] shadow-sm p-6">
                <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-indigo-400 text-[18px]">table_chart</span>
                    Download Template
                </h3>
                <p class="text-xs font-bold text-slate-500 mb-4 leading-relaxed">
                    Gunakan template berikut sebagai panduan format file yang benar.
                </p>
                <div class="space-y-2">
                    <a href="{{ route('admin.medical-records.template', ['category' => 'balita']) }}"
                       class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl bg-blue-50 border border-blue-100 text-blue-700 text-xs font-black hover:bg-blue-100 transition-all group">
                        <span class="material-symbols-outlined text-[20px] group-hover:scale-110 transition-transform">child_care</span>
                        <div>
                            <div class="font-black">Balita / Bayi</div>
                            <div class="text-[10px] font-bold text-blue-400 uppercase tracking-wider">template_balita.csv</div>
                        </div>
                        <span class="material-symbols-outlined text-[18px] ml-auto opacity-50">download</span>
                    </a>
                    <a href="{{ route('admin.medical-records.template', ['category' => 'ibu_hamil']) }}"
                       class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl bg-pink-50 border border-pink-100 text-pink-700 text-xs font-black hover:bg-pink-100 transition-all group">
                        <span class="material-symbols-outlined text-[20px] group-hover:scale-110 transition-transform">pregnant_woman</span>
                        <div>
                            <div class="font-black">Ibu Hamil</div>
                            <div class="text-[10px] font-bold text-pink-400 uppercase tracking-wider">template_ibu_hamil.csv</div>
                        </div>
                        <span class="material-symbols-outlined text-[18px] ml-auto opacity-50">download</span>
                    </a>
                    <a href="{{ route('admin.medical-records.template', ['category' => 'lansia']) }}"
                       class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl bg-purple-50 border border-purple-100 text-purple-700 text-xs font-black hover:bg-purple-100 transition-all group">
                        <span class="material-symbols-outlined text-[20px] group-hover:scale-110 transition-transform">elderly</span>
                        <div>
                            <div class="font-black">Lansia</div>
                            <div class="text-[10px] font-bold text-purple-400 uppercase tracking-wider">template_lansia.csv</div>
                        </div>
                        <span class="material-symbols-outlined text-[18px] ml-auto opacity-50">download</span>
                    </a>
                </div>
            </div>

            {{-- Petunjuk Kolom --}}
            <div class="bg-white border border-slate-100 rounded-[2rem] shadow-sm p-6">
                <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-amber-400 text-[18px]">info</span>
                    Kolom yang Dikenali
                </h3>
                <div class="space-y-2.5">
                    <div class="flex items-start gap-2.5">
                        <code class="text-[9px] font-black bg-slate-100 text-teal-700 px-2 py-0.5 rounded-lg whitespace-nowrap shrink-0 mt-0.5">NIK / nik</code>
                        <span class="text-[11px] font-bold text-slate-500 leading-snug">Nomor Induk Kependudukan (16 digit)</span>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <code class="text-[9px] font-black bg-slate-100 text-teal-700 px-2 py-0.5 rounded-lg whitespace-nowrap shrink-0 mt-0.5">nama_anak / nama</code>
                        <span class="text-[11px] font-bold text-slate-500 leading-snug">Nama lengkap pasien</span>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <code class="text-[9px] font-black bg-slate-100 text-teal-700 px-2 py-0.5 rounded-lg whitespace-nowrap shrink-0 mt-0.5">tgl_lahir</code>
                        <span class="text-[11px] font-bold text-slate-500 leading-snug">Tanggal lahir (YYYY-MM-DD)</span>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <code class="text-[9px] font-black bg-slate-100 text-teal-700 px-2 py-0.5 rounded-lg whitespace-nowrap shrink-0 mt-0.5">jk</code>
                        <span class="text-[11px] font-bold text-slate-500 leading-snug">Jenis kelamin (L / P)</span>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <code class="text-[9px] font-black bg-slate-100 text-teal-700 px-2 py-0.5 rounded-lg whitespace-nowrap shrink-0 mt-0.5">nm_ortu / suami</code>
                        <span class="text-[11px] font-bold text-slate-500 leading-snug">Nama orang tua / suami</span>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <code class="text-[9px] font-black bg-slate-100 text-teal-700 px-2 py-0.5 rounded-lg whitespace-nowrap shrink-0 mt-0.5">TANGGAL UKUR</code>
                        <span class="text-[11px] font-bold text-slate-500 leading-snug">Tanggal kunjungan (YYYY-MM-DD)</span>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <code class="text-[9px] font-black bg-slate-100 text-teal-700 px-2 py-0.5 rounded-lg whitespace-nowrap shrink-0 mt-0.5">BERAT</code>
                        <span class="text-[11px] font-bold text-slate-500 leading-snug">Berat badan (kg)</span>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <code class="text-[9px] font-black bg-slate-100 text-teal-700 px-2 py-0.5 rounded-lg whitespace-nowrap shrink-0 mt-0.5">TINGGI</code>
                        <span class="text-[11px] font-bold text-slate-500 leading-snug">Tinggi badan (cm)</span>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <code class="text-[9px] font-black bg-slate-100 text-teal-700 px-2 py-0.5 rounded-lg whitespace-nowrap shrink-0 mt-0.5">lingkar_kepala</code>
                        <span class="text-[11px] font-bold text-slate-500 leading-snug">Lingkar kepala (cm)</span>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <code class="text-[9px] font-black bg-slate-100 text-teal-700 px-2 py-0.5 rounded-lg whitespace-nowrap shrink-0 mt-0.5">vitamin</code>
                        <span class="text-[11px] font-bold text-slate-500 leading-snug">Vitamin A diberikan (Ya / Tidak)</span>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <code class="text-[9px] font-black bg-slate-100 text-teal-700 px-2 py-0.5 rounded-lg whitespace-nowrap shrink-0 mt-0.5">Imunisasi</code>
                        <span class="text-[11px] font-bold text-slate-500 leading-snug">Jenis imunisasi yang diberikan</span>
                    </div>
                </div>
            </div>

            {{-- Catatan Penting --}}
            <div class="bg-amber-50 border border-amber-100 rounded-[2rem] p-6">
                <h3 class="text-[10px] font-black uppercase tracking-widest text-amber-600 mb-3 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">warning</span>
                    Catatan Penting
                </h3>
                <ul class="space-y-2 text-xs font-bold text-amber-700 leading-relaxed">
                    <li class="flex items-start gap-2">
                        <span class="text-amber-400 mt-0.5 shrink-0">•</span>
                        Warga yang sudah ada di sistem akan <strong>diperbarui</strong> datanya, tidak duplikat.
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-amber-400 mt-0.5 shrink-0">•</span>
                        Rekam medis duplikat (pasien + tanggal sama) akan <strong>dilewati</strong>.
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-amber-400 mt-0.5 shrink-0">•</span>
                        NIK tidak valid akan dibuatkan <strong>NIK sementara</strong> otomatis.
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-amber-400 mt-0.5 shrink-0">•</span>
                        Format tanggal yang didukung: YYYY-MM-DD, DD/MM/YYYY, serial Excel.
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
function handleFileSelect(input) {
    if (input.files && input.files[0]) {
        showFileInfo(input.files[0]);
    }
}

function handleDrop(event) {
    event.preventDefault();
    var dropZone = document.getElementById('drop-zone');
    dropZone.classList.remove('border-teal-400', 'bg-teal-50/30');

    var file = event.dataTransfer.files[0];
    if (!file) return;

    var allowedExt = ['csv', 'xlsx', 'xls'];
    var ext = file.name.split('.').pop().toLowerCase();
    if (!allowedExt.includes(ext)) {
        alert('Format file tidak didukung. Gunakan CSV, XLSX, atau XLS.');
        return;
    }

    var dt = new DataTransfer();
    dt.items.add(file);
    document.getElementById('file-input').files = dt.files;
    showFileInfo(file);
}

function showFileInfo(file) {
    document.getElementById('drop-default').classList.add('hidden');
    var selected = document.getElementById('drop-selected');
    selected.classList.remove('hidden');

    document.getElementById('file-name').textContent = file.name;
    var sizeMb = (file.size / 1024 / 1024).toFixed(2);
    document.getElementById('file-size').textContent = sizeMb + ' MB';
}

document.getElementById('import-form').addEventListener('submit', function() {
    var btn = document.getElementById('submit-btn');
    btn.innerHTML = '<span class="material-symbols-outlined text-[20px] animate-spin">progress_activity</span> Memproses...';
    btn.disabled = true;
    btn.classList.add('opacity-75');
});
</script>
