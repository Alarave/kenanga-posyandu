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
        <style>
            table thead tr {
                background-color: var(--color-surface-container-low, #f0f5f2);
            }
            table thead th {
                padding: 12px 16px;
                text-align: left;
                font-size: 11px;
                font-weight: 700;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                color: var(--color-on-surface-variant, #3d4947);
                border-bottom: 1px solid var(--color-outline-variant, #bcc9c6);
                white-space: nowrap;
            }
            table tbody tr {
                border-bottom: 1px solid var(--color-outline-variant, #bcc9c6);
                transition: background-color 0.15s;
            }
            table tbody tr:last-child {
                border-bottom: none;
            }
            table tbody tr:hover {
                background-color: var(--color-surface-container-low, #f0f5f2);
            }
            table tbody td {
                padding: 13px 16px;
                color: var(--color-on-surface, #171d1c);
                vertical-align: middle;
            }
        </style>

        {{ $slot }}
    </table>
</div>
