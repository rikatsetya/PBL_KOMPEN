@section('content')
    
    @extends('layouts.template')
    <div class="container mt-5">
        <h1>Dashboard</h1>
        <div class="row">
            <!-- Statistik Tugas -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Tugas</div>
                    <div class="card-body">
                        <p>Admin: {{ $tugasAdmin }} tugas ({{ $adminDikerjakan }} mahasiswa ambil tugas)</p>
                        <p>Dosen: {{ $tugasDosen }} tugas ({{ $dosenDikerjakan }} mahasiswa ambil tugas)</p>
                        <p>Tendik: {{ $tugasTendik }} tugas ({{ $tendikDikerjakan }} mahasiswa ambil tugas)</p>
                    </div>
                </div>
            </div>
    
            <!-- Statistik Absensi -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Absensi</div>
                    <div class="card-body">
                        <p>Total Mahasiswa: {{ $totalAbsensi }}</p>
                        <p>Lunas: {{ $lunas }}</p>
                        <p>Belum Lunas: {{ $belumLunas }}</p>
                        <p>Tidak Memiliki Alpha: {{ $alphaKosong }}</p>
                    </div>
                </div>
            </div>
    
            <!-- Periode Aktif -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Periode Aktif</div>
                    <div class="card-body">
                        @if ($periodeAktif)
                            <p>Periode: {{ $periodeAktif->periode_tahun }}</p>
                        @else
                            <p>Tidak ada periode aktif saat ini.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
