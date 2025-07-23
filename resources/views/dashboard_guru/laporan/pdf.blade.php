<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rekap Kehadiran</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            margin: 40px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
        }

        .header p {
            margin: 4px 0;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
        }

        .ttd {
            margin-top: 50px;
            width: 100%;
            display: flex;
            justify-content: flex-end;
        }

        .ttd .box {
            text-align: left;
            width: 250px;
        }

        .ttd .box p {
            margin: 4px 0;
        }

        .ttd .box .space {
            height: 80px;
        }

        .nama {
            text-align: left;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>SD Negeri Tukdana 1</h1>
        <p>Jl. Pendidikan No. 123, Kota Pendidikan</p>
        <p>Telp. (0341) 123456 | Email: info@sdcontoh.sch.id</p>
    </div>

    <h2 style="text-align:center;">Rekap Kehadiran Siswa</h2>
    <p style="">Bulan: {{ $bulan }} / {{ $tahun }}</p>
    <p style="">Kelas: {{ $guru->kelas->nama_kelas }}</p>
    <p style="">Wali Kelas: {{ $guru->nama_guru }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Hadir</th>
                <th>Izin</th>
                <th>Alfa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekap as $i => $r)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $r['nis'] }}</td>
                    <td class="nama">{{ $r['nama'] }}</td>
                    <td>{{ $r['hadir'] }}</td>
                    <td>{{ $r['izin'] }}</td>
                    <td>{{ $r['alfa'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="ttd">
        <div class="box">
            <p>Tukdana, <span>{{ date('d-m-Y') }}</span></p>
            <p>Wali Kelas</p>
            <div class="space"></div>
            <p><strong>{{ $guru->nama_guru }}</strong></p>
            <p>NIP: {{ $guru->nip ?? '-' }}</p>
        </div>
    </div>

</body>

</html>