{{-- ── C. DETAIL MODAL DIALOG ── --}}
<div id="kaderModal" class="fixed inset-0 z-50 hidden bg-slate-950/70 backdrop-blur-md items-center justify-center p-4 transition-opacity duration-300">
    <div class="bg-white/95 dark:bg-slate-900/95 border border-white/20 dark:border-slate-800 rounded-[2.5rem] max-w-3xl w-full overflow-hidden shadow-2xl relative transform scale-95 opacity-0 transition-all duration-300 flex flex-col md:flex-row" id="kaderModalContent">
        
        {{-- Close button --}}
        <button onclick="closeKaderModal()" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 z-10 w-10 h-10 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center transition-transform hover:rotate-90 duration-300 shadow-sm">
            <span class="material-symbols-outlined text-[20px]">close</span>
        </button>

        {{-- Left side image --}}
        <div class="md:w-5/12 bg-slate-50/50 dark:bg-slate-950/50 p-8 flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-slate-100 dark:border-slate-800">
            <div class="w-40 h-40 rounded-2xl overflow-hidden border-4 border-white dark:border-slate-900 shadow-xl mb-6 bg-slate-200 dark:bg-slate-800">
                <img id="modalImage" src="" alt="Kader Photo" class="w-full h-full object-cover object-center">
            </div>
            <h3 id="modalName" class="text-2xl font-black text-slate-900 dark:text-white font-jakarta text-center leading-tight"></h3>
            <span id="modalRole" class="inline-block mt-3 px-4 py-2 bg-primary/10 text-primary text-sm font-black uppercase tracking-wider rounded-xl border border-primary/20"></span>
        </div>

        {{-- Right side info fields --}}
        <div class="md:w-7/12 p-8 md:p-10 flex flex-col gap-6">
            <div>
                <h4 class="text-sm md:text-base font-black uppercase tracking-widest text-primary dark:text-primary font-jakarta mb-6 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[18px]">badge</span>
                    Biodata Lengkap Kader
                </h4>
                
                <div class="grid grid-cols-1 gap-5 text-base">
                    {{-- Pendidikan --}}
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-slate-600 dark:text-slate-400 mt-0.5 text-[22px]">school</span>
                        <div class="flex flex-col gap-0.5">
                            <span class="text-sm text-slate-600 dark:text-slate-400 font-extrabold uppercase tracking-wider">Pendidikan</span>
                            <span id="modalPendidikan" class="text-base md:text-lg font-bold text-slate-900 dark:text-slate-100"></span>
                        </div>
                    </div>
                    {{-- Alamat --}}
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-slate-600 dark:text-slate-400 mt-0.5 text-[22px]">home_pin</span>
                        <div class="flex flex-col gap-0.5">
                            <span class="text-sm text-slate-600 dark:text-slate-400 font-extrabold uppercase tracking-wider">Alamat Lengkap</span>
                            <span id="modalAlamat" class="text-base md:text-lg font-bold text-slate-900 dark:text-slate-100 leading-relaxed"></span>
                        </div>
                    </div>
                    {{-- Email --}}
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-slate-600 dark:text-slate-400 mt-0.5 text-[22px]">alternate_email</span>
                        <div class="flex flex-col gap-0.5">
                            <span class="text-sm text-slate-600 dark:text-slate-400 font-extrabold uppercase tracking-wider">Email</span>
                            <span id="modalEmail" class="text-base md:text-lg font-bold text-slate-900 dark:text-slate-100 break-all"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function openKaderModal(name, role, pendidikan, alamat, email, image) {
    document.getElementById('modalImage').src = image;
    document.getElementById('modalName').innerText = name;
    document.getElementById('modalRole').innerText = role;
    document.getElementById('modalPendidikan').innerText = pendidikan;
    document.getElementById('modalAlamat').innerText = alamat;
    document.getElementById('modalEmail').innerText = email && email !== '-' ? email : '-';

    const modal = document.getElementById('kaderModal');
    const content = document.getElementById('kaderModalContent');
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeKaderModal() {
    const modal = document.getElementById('kaderModal');
    const content = document.getElementById('kaderModalContent');
    
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}

document.getElementById('kaderModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeKaderModal();
    }
});
</script>
