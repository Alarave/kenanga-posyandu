<div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-100 pb-4">
    {{-- Breadcrumb Navigation --}}
    <nav aria-label="Breadcrumb" style="font-family:'Public Sans',sans-serif;">
        <ol class="flex items-center flex-wrap gap-2 text-xs font-bold text-slate-400">
            <li class="flex items-center">
                <a href="{{ route('dashboard') }}" class="hover:text-teal-600 flex items-center gap-1.5 transition-colors">
                    <span class="material-symbols-outlined text-[16px] leading-none">home</span>
                    Dashboard
                </a>
            </li>
            @if(request()->path() !== 'dashboard')
                <li class="flex items-center text-slate-300" aria-hidden="true">
                    <span class="material-symbols-outlined text-[14px] leading-none">chevron_right</span>
                </li>
                <li class="flex items-center">
                    <span class="text-slate-700 capitalize flex items-center gap-1">
                        @php
                            $segment = request()->segment(2);
                            $icon = match($segment) {
                                'gallery' => 'collections',
                                'articles' => 'newspaper',
                                'patients' => 'group',
                                'schedules' => 'calendar_month',
                                default => 'folder'
                            };
                        @endphp
                        @if($icon)
                            <span class="material-symbols-outlined text-[16px] text-teal-600/80 leading-none">{{ $icon }}</span>
                        @endif
                        {{ str_replace('-', ' ', $segment) }}
                    </span>
                </li>
            @endif
        </ol>
    </nav>

    {{-- Current Date Badge --}}
    <div class="flex items-center gap-2 text-xs font-black text-slate-500 bg-slate-100/80 border border-slate-200 px-3.5 py-2 rounded-2xl shadow-sm whitespace-nowrap max-w-fit" style="font-family:'Public Sans',sans-serif;">
        <span class="material-symbols-outlined text-[16px] text-teal-600 leading-none">calendar_today</span>
        {{ now()->translatedFormat('d F Y') }}
    </div>
</div>