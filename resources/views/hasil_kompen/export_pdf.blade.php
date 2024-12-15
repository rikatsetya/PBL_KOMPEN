<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 6px 20px 5px 20px;
            line-height: 1.5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 5px;
        }

        th {
            text-align: left;
        }

        .d-block {
            display: block;
        }

        img.image {
            width: auto;
            height: 80px;
            max-width: 150px;
            max-height: 150px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .p-1 {
            padding: 5px 1px 5px 1px;
        }

        .font-10 {
            font-size: 10pt;
        }

        .font-11 {
            font-size: 11pt;
        }

        .font-12 {
            font-size: 12pt;
        }

        .font-13 {
            font-size: 13pt;
        }

        .border-bottom-header {
            border-bottom: 1px solid;
        }

        .border-all,
        .border-all th,
        .border-all td {
            border: 1px solid;
        }

        .font-bold {
            font-weight: bold;
        }

        .header-table td {
            padding: 5px;
            text-align: left;
            vertical-align: top;
        }
    </style>
</head>

<body>
    <!-- Surat Header -->
    <table class="border-bottom-header">
        <tr>
            <td width="15%" class="text-center"><img src="{{ asset('images/logo_polinema.png') }}" style="height: 80px; width:80px"> </td>
            <td width="85%">
                <span class="text-center d-block font-11 font-bold mb-1">KEMENTERIAN
                    PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</span>
                <span class="text-center d-block font-13 font-bold mb-1">POLITEKNIK NEGERI
                    MALANG</span>
                <span class="text-center d-block font-10">Jl. Soekarno-Hatta No. 9 Malang
                    65141</span>
                <span class="text-center d-block font-10">Telepon (0341) 404424 Pes. 101-
                    105, 0341-404420, Fax. (0341) 404420</span>
                <span class="text-center d-block font-10">Laman: www.polinema.ac.id</span>
            </td>
        </tr>
    </table>

    <h3 class="text-center font-13 font-bold">SURAT KETERANGAN BEBAS KOMPENSASI</h3>

    <!-- Informasi Surat -->
    @if ($hasil->mahasiswa)
        <table class="header-table">
            <tr>
                <td width="25%">Nama</td>
                <td>: {{ $hasil->mahasiswa->mahasiswa_nama }}</td>
            </tr>
            <tr>
                <td>NIM</td>
                <td>: {{ $hasil->mahasiswa->nim }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>: {{ $hasil->mahasiswa->kelas }}</td>
            </tr>
            <tr>
                <td>Semester</td>
                <td>: {{ $hasil->periode->periode_tahun }}</td>
            </tr>
        </table>

        <p class="font-11">
            Dengan ini menyatakan bahwa mahasiswa yang bersangkutan telah menyelesaikan semua kewajiban kompensasi
            yang berlaku dan dinyatakan <strong>BEBAS KOMPENSASI</strong>.
            Dengan demikian, yang bersangkutan diperkenankan untuk mengikuti Ujian Akhir Semester (UAS) pada
            semester yang sedang berjalan.
        </p>

        <p class="font-11">Demikian surat keterangan ini dibuat agar dapat digunakan sebagaimana mestinya.</p>

        <!-- Footer -->
        <table class="header-table">
            <tr>
                <td width="50%" class="text-right">
                    <!-- Date and 'Mengetahui' text without extra space -->
                    <p class="font-11 text-right">
                        Malang, {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}<br>
                    </p>
                    <p class="text-right">
                        Mengetahui,<br><br>
                        <!-- Logo image -->
                        <img src="{{ asset('images/logo_polinema.png') }}"
                            style="height: 80px; width: 80px; display: block; margin: 0 auto;"><br><br>
                        Ka. Program Studi
                    </p>
                </td>
            </tr>
        </table>
    @endif
</body>

</html>
