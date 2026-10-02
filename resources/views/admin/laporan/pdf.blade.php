<!DOCTYPE html>
<html>
<head>
    <title>Laporan Tracer Study</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .status-badge {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Data Alumni Tracer Study</h2>
        <p>SMK Swasta Budhi darma Indrapura</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NISN</th>
                <th>Nama Lengkap</th>
                <th>Tahun Lulus</th>
                <th>Jurusan</th>
                <th>Status Saat Ini</th>
                <th>Kontak (HP/Email)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($alumni as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $row->nisn }}</td>
                <td>{{ $row->nama }}</td>
                <td>{{ $row->tahunLulus ? $row->tahunLulus->tahun : '-' }}</td>
                <td>{{ $row->jurusan ? $row->jurusan->kode : '-' }}</td>
                <td>
                    @if($row->pekerjaan) Bekerja <br> @endif
                    @if($row->pendidikan) Kuliah <br> @endif
                    @if($row->usaha) Wirausaha <br> @endif
                    @if(!$row->pekerjaan && !$row->pendidikan && !$row->usaha)
                        Belum Mengisi Status
                    @endif
                </td>
                <td>
                    {{ $row->no_hp ?? '-' }} <br>
                    {{ $row->user ? $row->user->email : '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">Tidak ada data alumni.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
