{{--
    Posyandu Table Component
    ────────────────────────
    Wrapper tabel responsif dengan desain konsisten (Clinical Precision).

    Usage 1 (with slots):
        <x-layouts.ui.table>
            <x-slot:head>
                <th class="py-4 px-6 font-semibold">Nama</th>
                <th class="py-4 px-6 font-semibold text-center">Aksi</th>
            </x-slot:head>

            <x-slot:body>
                <tr class="hover:bg-surface-container-low transition-colors group">
                    <td class="py-4 px-6">Budi</td>
                    <td class="py-4 px-6 text-center">...</td>
                </tr>
            </x-slot:body>
        </x-layouts.ui.table>

    Usage 2 (manual inner structure):
        <x-layouts.ui.table>
            <thead>...</thead>
            <tbody>...</tbody>
        </x-layouts.ui.table>
--}}

<div class="overflow-x-auto">
    <table {{ $attributes->merge(['class' => 'w-full text-left border-collapse min-w-[800px]']) }}>
        
        @if(isset($head))
            <thead>
                <tr class="bg-surface-container-low border-b border-outline-variant font-label-md text-label-md text-on-surface-variant">
                    {{ $head }}
                </tr>
            </thead>
        @endif

        @if(isset($body))
            <tbody class="font-body-md text-body-md text-on-surface divide-y divide-surface-container-high">
                {{ $body }}
            </tbody>
        @else
            {{ $slot }}
        @endif
        
    </table>
</div>
