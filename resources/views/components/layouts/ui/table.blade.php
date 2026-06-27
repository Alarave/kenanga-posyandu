{{--
    Posyandu Table Component
    ────────────────────────
    Wrapper tabel responsif dengan desain konsisten.

    Usage:
        <x-table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Budi</td>
                    <td>Aktif</td>
                </tr>
            </tbody>
        </x-table>
--}}

<div class="w-full overflow-x-auto rounded-xl border border-outline-variant"
     style="font-family:'Public Sans',sans-serif;">
    <table {{ $attributes->merge([
        'class' => 'w-full text-[13px] text-on-surface border-collapse'
    ]) }}>

        {{-- Inject default thead styles via CSS --}}
        

        {{ $slot }}
    </table>
</div>
