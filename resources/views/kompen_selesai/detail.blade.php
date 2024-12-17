@extends('layouts.template')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Detail Tugas</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-sm table-bordered table-striped">
                <tr>
                    <th class="text-right">Nama Tugas</th>
                    <td>{{ $selesai->tugas->tugas_nama }}</td>
                </tr>
                <tr>
                    <th class="text-right">Nama Mahasiswa</th>
                    <td>{{ $selesai->mahasiswa->mahasiswa_nama }}</td>
                </tr>
                <tr>
                    <th class="text-right">Foto Sebelum</th>
                    <td>
                        @if($selesai->foto_sebelum && file_exists(public_path('foto_sebelum/' . $selesai->foto_sebelum)))
                            <img src="{{ asset('foto_sebelum/' . $selesai->foto_sebelum) }}" width="100" height="100" alt="Foto Sebelum">
                        @else
                            <span>No Image</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="text-right">Foto Sesudah</th>
                    <td>
                        @if($selesai->foto_sesudah && file_exists(public_path('foto_sesudah/' . $selesai->foto_sesudah)))
                            <img src="{{ asset('foto_sesudah/' . $selesai->foto_sesudah) }}" width="100" height="100" alt="Foto Sesudah">
                        @else
                            <span>No Image</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="text-right">Tanggal</th>
                    <td>{{ $selesai->tanggal }}</td>
                    {{-- <td>{{ \Carbon\Carbon::parse($selesai->tanggal)->format('d-m-Y') }}</td> --}}
                </tr>
                <tr>
                    <th class="text-right">Status</th>
                    <td>{{ $selesai->status ?: 'Belum Diperbarui' }}</td>
                </tr>
                @if ($selesai->status == 'tolak')
                    <tr>
                        <th class="text-right">Alasan Penolakan</th>
                        <td>{{ $selesai->alasan }}</td>
                    </tr>
                @endif
            </table>

            <!-- Only show this part if status is not null -->
            @if ($selesai->status == null)
                <div class="alert alert-info">
                    <p>Status belum diperbarui. Admin akan mengupdate status setelah pengecekan.</p>
                </div>
            @endif

            <!-- Tombol Kembali -->
            <a href="{{ url('/kompen_selesai') }}" class="btn btn-primary">Kembali</a>
        </div>
    </div>
@endsection
