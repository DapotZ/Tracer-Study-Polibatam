<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #000;
        }

        h3 {
            font-size: 14pt;
            margin-bottom: 10px;
        }

        p {
            text-align: justify;
            margin-bottom: 12px;
        }

        ul {
            padding-left: 20px;
            margin-bottom: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: center;
        }

        th {
            background-color: #eaeaea;
            font-weight: bold;
        }

        .left {
            text-align: left;
        }

        .summary {
            margin-top: 20px;
            font-style: italic;
        }
    </style>
</head>
<body>

<h3>3.1 Profil Umum Alumni</h3>

<p>
    Tracer Study Politeknik Negeri Batam tahun <b>{{ $tahun }}</b> dilaksanakan untuk memperoleh gambaran profil umum alumni setelah menyelesaikan pendidikan di masing-masing program studi. Proses pengumpulan data dilakukan melalui sistem terintegrasi, yang memungkinkan administrator menentukan target responden berdasarkan tahun kelulusan atau seluruh alumni secara menyeluruh.
</p>

<p>
    Pada pelaksanaan tracer study tahun <b>{{ $tahun }}</b>, kuesioner ditujukan kepada alumni dari <b>{{ count($dataProdi) }}</b> program studi, yaitu <b>{{ $daftarProdi }}</b>. Masing-masing alumni menerima kuesioner yang telah disesuaikan dengan latar belakang status saat ini, meliputi: bekerja, belum bekerja, melanjutkan studi, berwirausaha, dan sedang mencari pekerjaan.
</p>

<p>
    Dari total <b>{{ $totalTarget }}</b> alumni yang menjadi target tracer, tercatat sebanyak <b>{{ $totalResponden }}</b> alumni memberikan respons. Berikut adalah rincian tingkat partisipasi berdasarkan program studi:
</p>

<ul>
@foreach ($dataProdi as $prodi)
    <li><b>{{ $prodi['prodi'] }}</b>: dari {{ $prodi['jumlah'] }} alumni, sebanyak {{ $prodi['mengisi'] }} orang ({{ $prodi['persen'] }}%) telah mengisi kuesioner.</li>
@endforeach
</ul>

<p class="summary">
    Data ini memberikan indikator awal dalam menilai keterlibatan alumni serta efektivitas pelaksanaan tracer study sebagai upaya pengembangan program studi dan pemetaan mutu lulusan.
</p>

<table>
    <thead>
        <tr>
            <th>Program Studi</th>
            <th>Jumlah Alumni</th>
            <th>Mengisi</th>
            <th>Tidak Mengisi</th>
            <th>Persentase</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataProdi as $prodi)
            <tr>
                <td class="left">{{ $prodi['prodi'] }}</td>
                <td>{{ $prodi['jumlah'] }}</td>
                <td>{{ $prodi['mengisi'] }}</td>
                <td>{{ $prodi['tidak_mengisi'] }}</td>
                <td>{{ $prodi['persen'] }}%</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
