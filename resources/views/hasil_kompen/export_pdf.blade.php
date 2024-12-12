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

        .d-flex {
            display: flex;
        }

        .flex-col {
            flex-direction: column;
        }

        .j-right {
            justify-content: flex-end;
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

        .m-0 {
            margin: 0;
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
            <td width="15%" class="text-center"><img src="../public/images/logo_polinema.png" style="height: 80px; width:80px"></td>
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
            <td style="text-align: right;">
                <div style="display: inline-block; text-align: center;">
                    <!-- Date and 'Mengetahui' text without extra space -->
                    <p style="font-size: 11pt; margin: 0; text-align: right;">
                        Malang, {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}
                    </p>
                    <p style="margin: 0; text-align: center;">
                        Mengetahui,<br><br>
                        <!-- Qrcode image -->
                        <img src="../public/{{ $hasil->qrcode }}"
                            style="height: 100px; width: 100px; display: block; margin: 0 auto;">
                        <br><br>
                        Ka. Program Studi
                    </p>
                </div>
            </td>
        </tr>
    </table>

    @else
    <p>Data tidak lengkap atau tidak ditemukan.</p>
    @endif
</body>

</html>