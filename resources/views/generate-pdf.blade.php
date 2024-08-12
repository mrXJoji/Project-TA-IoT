<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Keputusan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 0.9em;
            background-color: #fff;
            box-shadow: 0 2px 3px rgba(0,0,0,0.1);
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 12px;
        }
        .table th {
            background-color: #f1f1f1;
            color: #333;
            text-transform: uppercase;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>Halaman Hasil Keputusan</h1>

    <h4>Nilai Terbaru</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Indikator</th>
                <th>Nilai Terbaru</th>
                <th>Kategori</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Suhu Udara</td>
                <td>{{ $latestValues['suhu'] ? $latestValues['suhu'] . ' °C' : 'Data tidak tersedia' }}</td>
                <td>{{ $kategori['suhu'] }}</td>
            </tr>
            <tr>
                <td>Kelembaban</td>
                <td>{{ $latestValues['kelembaban'] ? $latestValues['kelembaban'] . ' %' : 'Data tidak tersedia' }}</td>
                <td>{{ $kategori['kelembaban'] }}</td>
            </tr>
            <tr>
                <td>Gas Amonia</td>
                <td>{{ $latestValues['amonia'] ? $latestValues['amonia'] . ' ppm' : 'Data tidak tersedia' }}</td>
                <td>{{ $kategori['amonia'] }}</td>
            </tr>
            <tr>
                <td>Kecepatan Udara</td>
                <td>{{ $latestValues['udara'] ? $latestValues['udara'] . ' km/h' : 'Data tidak tersedia' }}</td>
                <td>{{ $kategori['udara'] }}</td>
            </tr>
        </tbody>
    </table>

    <h4>Hasil</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Status</th>
                <th>Tindakan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $outputKondisi }}</td>
                <td>{{ $tindakan }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
 