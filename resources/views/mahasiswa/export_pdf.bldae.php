<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 6px 20px 5px 20px;
            line-height: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 4px 3px;
        }

        th {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .border-all,
        .border-all th,
        .border-all td {
            border: 1px solid;
        }
    </style>
</head>

<body>
    <h3 class="text-center">LAPORAN ABSENSI MAHASISWA</h3>
    <table class="border-all">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Absensi ID</th>
                <th>Nama Mahasiswa</th>
                <th>Periode Tahun</th>
                <th class="text-center">Alpha</th>
                <th class="text-center">Poin</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mahasiswakmp as $data)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $data->absensi_id }}</td>
                    <td>{{ $data->mahasiswa->mahasiswa_nama }}</td>
                    <td>{{ $data->periode->periode_tahun }}</td>
                    <td class="text-center">{{ $data->alpha }}</td>
                    <td class="text-center">{{ $data->poin }}</td>
                    <td>{{ $data->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
