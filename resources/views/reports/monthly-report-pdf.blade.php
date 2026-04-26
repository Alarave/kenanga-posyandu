<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bulanan Posyandu</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .header p {
            margin: 5px 0;
            font-size: 12px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            padding: 5px;
            background-color: #f0f0f0;
            border-left: 4px solid #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table th {
            background-color: #f0f0f0;
            font-weight: bold;
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .info-table td {
            border: none;
            padding: 5px 10px;
        }
        .info-table td:first-child {
            font-weight: bold;
            width: 200px;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 11px;
        }
        .signature {
            margin-top: 60px;
            text-align: right;
        }
        .signature-line {
            display: inline-block;
            width: 200px;
            border-top: 1px solid #333;
            margin-top: 60px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN BULANAN POSYANDU</h1>
        <p><strong>{{ $reportData['posyandu']['name'] }}</strong></p>
        <p>{{ $reportData['posyandu']['address'] }}</p>
        <p>Periode: {{ $reportData['period']['month_name'] }} {{ $reportData['period']['year'] }}</p>
    </div>

    <!-- Ringkasan -->
    <div class="section">
        <div class="section-title">RINGKASAN</div>
        <table class="info-table">
            <tr>
                <td>Total Kunjungan</td>
                <td>: {{ $reportData['total_visits'] }} kunjungan</td>
            </tr>
            <tr>
                <td>Pemberian Vitamin A</td>
                <td>: {{ $reportData['vitamin_a_given'] }} kali</td>
            </tr>
            <tr>
                <td>Pemberian Pill FE</td>
                <td>: {{ $reportData['pill_fe_given'] }} kali</td>
            </tr>
        </table>
    </div>

    <!-- Kunjungan per Kategori -->
    <div class="section">
        <div class="section-title">KUNJUNGAN PER KATEGORI</div>
        <table>
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th style="text-align: center;">Jumlah Kunjungan</th>
                    <th style="text-align: center;">Total Sasaran Terdaftar</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $categoryNames = [
                        'balita' => 'Balita',
                        'ibu_hamil' => 'Ibu Hamil',
                        'remaja' => 'Remaja',
                        'lansia' => 'Lansia',
                    ];
                @endphp
                @foreach($categoryNames as $key => $name)
                <tr>
                    <td>{{ $name }}</td>
                    <td style="text-align: center;">{{ $reportData['visits_by_category'][$key] ?? 0 }}</td>
                    <td style="text-align: center;">{{ $reportData['total_patients_by_category'][$key] ?? 0 }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Distribusi Status Gizi -->
    @if(!empty($reportData['nutrition_distribution']))
    <div class="section">
        <div class="section-title">DISTRIBUSI STATUS GIZI BALITA</div>
        <table>
            <thead>
                <tr>
                    <th>Status Gizi</th>
                    <th style="text-align: center;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportData['nutrition_distribution'] as $status => $count)
                <tr>
                    <td>{{ $status }}</td>
                    <td style="text-align: center;">{{ $count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Jadwal Kegiatan -->
    @if(!empty($reportData['schedules']))
    <div class="section">
        <div class="section-title">JADWAL KEGIATAN</div>
        <table>
            <thead>
                <tr>
                    <th>Judul Kegiatan</th>
                    <th>Tanggal</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportData['schedules'] as $schedule)
                <tr>
                    <td>{{ $schedule['title'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($schedule['date'])->format('d/m/Y H:i') }}</td>
                    <td>{{ $schedule['location'] }}</td>
                    <td>{{ ucfirst($schedule['status']) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <div class="signature">
        <p>Mengetahui,<br>Admin Posyandu</p>
        <div class="signature-line"></div>
        <p>(...........................)</p>
    </div>
</body>
</html>
