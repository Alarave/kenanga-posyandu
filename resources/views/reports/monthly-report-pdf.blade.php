<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pokja IV - Polished Template</title>
    <style>
        @page {
            margin: 0.5cm;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 7pt;
            line-height: 1.0;
            color: #000;
        }
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 11pt;
            margin-bottom: 5px;
        }
        .header-meta {
            float: right;
            border: 1px solid #000;
            width: 250px;
            margin-bottom: 10px;
        }
        .header-meta td {
            border: none;
            padding: 2px;
            font-size: 8pt;
        }
        .clear { clear: both; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0px;
            table-layout: fixed;
        }
        th, td {
            border: 1px solid #000;
            padding: 2px;
            text-align: center;
            overflow: hidden;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        
        /* Main Grid Alignment */
        .col-label { width: 25px; font-weight: bold; }
        .col-data { width: 22px; }
        .col-jml { width: 28px; background: #eee; }
        .col-uraian { text-align: left !important; font-size: 6pt; }

        /* Vertical Header Logic */
        .v-cell {
            height: 90px;
            position: relative;
            vertical-align: bottom;
            padding-bottom: 10px !important;
        }
        .v-text {
            display: block;
            transform: rotate(-90deg);
            white-space: nowrap;
            width: 20px;
            margin: 0 auto;
            text-align: left;
            font-weight: bold;
            font-size: 6.5pt;
        }

        .bg-gray { background: #eee; }
        
        .footer-table {
            width: 100%;
            margin-top: 5px;
        }
        .footer-table td {
            vertical-align: top;
            padding: 0;
            border: none;
        }
        
        .box-title {
            font-weight: bold;
            background: #eee;
            border: 1px solid #000;
            padding: 2px;
            font-size: 7pt;
        }

        .signature {
            float: right;
            width: 200px;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="title">LAPORAN POSYANDU UNTUK POKJA IV</div>

    <div class="header-meta">
        <table>
            <tr><td width="90">Nama Posyandu</td><td>: {{ $reportData['posyandu']['name'] }}</td></tr>
            <tr><td>Tgl Penimbangan</td><td>: {{ date('d F Y') }}</td></tr>
            <tr><td>Petugas (Binwil)</td><td>: -</td></tr>
            <tr><td>Tahun</td><td>: {{ $reportData['period']['year'] }}</td></tr>
        </table>
    </div>
    <div class="clear"></div>

    <!-- MAIN GRID SECTION -->
    <div style="width: 100%; display: table; border-bottom: 1px solid #000;">
        <div style="display: table-cell; width: 68%;">
            <table style="border-bottom: none;">
                <thead>
                    <tr>
                        <th rowspan="2" class="col-label"></th>
                        <th colspan="5">LAKI-LAKI</th>
                        <th colspan="5">PEREMPUAN</th>
                    </tr>
                    <tr>
                        <th class="col-data">0-5</th><th class="col-data">6-11</th><th class="col-data">12-23</th><th class="col-data">24-59</th><th class="col-jml">JML</th>
                        <th class="col-data">0-5</th><th class="col-data">6-11</th><th class="col-data">12-23</th><th class="col-data">24-59</th><th class="col-jml">JML</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(['S','K','N','T','U','B','O','GB','GK','GR','GL'] as $row)
                        @php $d = $reportData['pokja_iv']['rows'][$row]; @endphp
                        <tr>
                            <td class="col-label">{{ $row }}</td>
                            <td>{{ $d['male']['0-5'] ?: '' }}</td><td>{{ $d['male']['6-11'] ?: '' }}</td><td>{{ $d['male']['12-23'] ?: '' }}</td><td>{{ $d['male']['24-59'] ?: '' }}</td><td class="bg-gray">{{ $d['male']['total'] ?: '' }}</td>
                            <td>{{ $d['female']['0-5'] ?: '' }}</td><td>{{ $d['female']['6-11'] ?: '' }}</td><td>{{ $d['female']['12-23'] ?: '' }}</td><td>{{ $d['female']['24-59'] ?: '' }}</td><td class="bg-gray">{{ $d['female']['total'] ?: '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="display: table-cell; width: 32%; border-left: 1px solid #000; vertical-align: top;">
            <table style="border: none;">
                <thead>
                    <tr><th class="col-uraian">URAIAN</th><th width="20">L</th><th width="20">P</th><th width="35">Total</th></tr>
                </thead>
                <tbody>
                    @php
                        $cohorts = [
                            '0-11_baru' => '0-11 bln (baru)', '12-59_baru' => '12-59 bln (baru)',
                            '12_bln' => '12 bln', '24_bln' => '24 bln', '36_bln' => '36 bln',
                            '48_bln' => '48 bln', '60_bln' => '60 bln', 'lulus' => 'Lulus (BB 11,5)'
                        ];
                    @endphp
                    @foreach($cohorts as $key => $label)
                        <tr>
                            <td class="col-uraian">{{ $label }}</td>
                            <td>{{ $reportData['pokja_iv']['cohorts'][$key]['L'] ?: '-' }}</td>
                            <td>{{ $reportData['pokja_iv']['cohorts'][$key]['P'] ?: '-' }}</td>
                            <td class="bg-gray" style="font-size:5pt">anak</td>
                        </tr>
                    @endforeach
                    <tr><td class="col-uraian">Vit. A Bayi / Biru</td><td>-</td><td>-</td><td class="bg-gray" style="font-size:5pt">anak</td></tr>
                    <tr><td class="col-uraian">Vit. A Balita / Merah</td><td>-</td><td>-</td><td class="bg-gray" style="font-size:5pt">anak</td></tr>
                    <tr><td class="col-uraian">Jumlah Kader</td><td colspan="2">{{ $reportData['pokja_iv']['kader']['total'] }}</td><td class="bg-gray" style="font-size:5pt">orang</td></tr>
                    <tr><td class="col-uraian">Jml Kader Terlatih</td><td colspan="2">0</td><td class="bg-gray" style="font-size:5pt">orang</td></tr>
                    <tr><td class="col-uraian">Jml Kader Aktif</td><td colspan="2">0</td><td class="bg-gray" style="font-size:5pt">orang</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- IMMUNIZATION SECTION -->
    <div class="box-title">JUMLAH BAYI YANG DIIMUNISASI</div>
    <table>
        <thead>
            <tr>
                <th rowspan="2" width="25">HB0</th><th rowspan="2" width="25">BCG</th><th colspan="3">DPT PENTABIO</th><th colspan="4">POLIO</th><th rowspan="2" width="30">CAMPAK</th><th colspan="2">BOOSTER</th><th rowspan="2" width="25">IPV</th>
            </tr>
            <tr>
                <th>I</th><th>II</th><th>III</th><th>I</th><th>II</th><th>III</th><th>IV</th><th>PENTA</th><th>CMPK</th>
            </tr>
            <tr>
                @for($i=0; $i<13; $i++)
                    <th style="padding:0"><table style="border:none;"><tr><td style="border:none; width:50%; font-size:5pt">L</td><td style="border:none; width:50%; font-size:5pt; border-left:0.5px solid #000">P</td></tr></table></th>
                @endfor
            </tr>
        </thead>
        <tbody>
            <tr>
                @for($i=0; $i<13; $i++)
                    <td style="padding:0"><table style="border:none;"><tr><td style="border:none; width:50%">-</td><td style="border:none; width:50%; border-left:0.5px solid #000">-</td></tr></table></td>
                @endfor
            </tr>
        </tbody>
    </table>

    <!-- KB SECTION -->
    <table style="margin-top: 5px;">
        <thead>
            <tr>
                <th rowspan="2" class="v-cell"><div class="v-text">JML IBU HAMIL</div></th>
                <th rowspan="2" class="v-cell"><div class="v-text">DIPERIKSA</div></th>
                <th rowspan="2" class="v-cell"><div class="v-text">FE TABLET</div></th>
                <th rowspan="2" class="v-cell"><div class="v-text">TT I</div></th>
                <th rowspan="2" class="v-cell"><div class="v-text">TT II</div></th>
                <th rowspan="2" class="v-cell"><div class="v-text">JML IBU MENYUSUI</div></th>
                <th rowspan="2" class="v-cell"><div class="v-text">PUS</div></th>
                <th rowspan="2" class="v-cell"><div class="v-text">WUS</div></th>
                <th colspan="8" class="bg-gray">JML. AKSEPTOR KB</th>
                <th colspan="2" class="bg-gray">BKB</th>
                <th colspan="2" class="bg-gray">BKR</th>
                <th colspan="2" class="bg-gray">BKL</th>
            </tr>
            <tr>
                <th class="v-cell"><div class="v-text">KONDOM</div></th>
                <th class="v-cell"><div class="v-text">PIL</div></th>
                <th class="v-cell"><div class="v-text">IMPLANT</div></th>
                <th class="v-cell"><div class="v-text">MOP</div></th>
                <th class="v-cell"><div class="v-text">IUD</div></th>
                <th class="v-cell"><div class="v-text">SUNTIK</div></th>
                <th class="v-cell"><div class="v-text">MOW</div></th>
                <th class="v-cell"><div class="v-text">LAIN-LAIN</div></th>
                <th style="font-size:5pt">ADA</th><th style="font-size:5pt">TDK</th>
                <th style="font-size:5pt">ADA</th><th style="font-size:5pt">TDK</th>
                <th style="font-size:5pt">ADA</th><th style="font-size:5pt">TDK</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>-</td><td>-</td><td>{{ $reportData['pill_fe_given'] ?: '-' }}</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>
                <td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>
                <td>✓</td><td>-</td><td>✓</td><td>-</td><td>✓</td><td>-</td>
            </tr>
        </tbody>
    </table>

    <!-- FOOTER SUMMARY BLOCKS -->
    <div style="display:table; width:100%; margin-top:5px; border-collapse: separate; border-spacing: 2px;">
        <div style="display:table-cell; width:28%;">
            <div class="box-title">PETUGAS HADIR</div>
            <table>
                <tr><th colspan="2">KADER</th><th colspan="2">PLKB</th><th colspan="2">MEDIS</th></tr>
                <tr><th>L</th><th>P</th><th>L</th><th>P</th><th>L</th><th>P</th></tr>
                <tr><td>-</td><td>{{ $reportData['pokja_iv']['kader']['total'] }}</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>
            </table>
        </div>
        <div style="display:table-cell; width:28%;">
            <div class="box-title">BALITA DIARE</div>
            <table>
                <tr><th colspan="2">JUMLAH</th><th colspan="2">DPT ORALIT</th></tr>
                <tr><th>L</th><th>P</th><th>L</th><th>P</th></tr>
                <tr><td>-</td><td>-</td><td>-</td><td>-</td></tr>
            </table>
        </div>
        <div style="display:table-cell; width:20%;">
            <div class="box-title">JML BAYI/BALITA</div>
            <table>
                <tr><th colspan="2">LAHIR</th><th colspan="2">MATI</th></tr>
                <tr><th>L</th><th>P</th><th>L</th><th>P</th></tr>
                <tr><td>-</td><td>-</td><td>-</td><td>-</td></tr>
            </table>
        </div>
        <div style="display:table-cell; width:24%;">
            <div class="box-title">KETERANGAN</div>
            <div style="border:1px solid #000; height:34px; padding:2px"></div>
        </div>
    </div>

    <div class="signature">
        <p>Mengetahui,<br>Admin Posyandu</p>
        <br><br>
        <p><strong>Sri Hartati</strong></p>
        <p style="font-size:6pt; margin-top:-5px">STEMPEL POSYANDU</p>
    </div>
</body>
</html>
