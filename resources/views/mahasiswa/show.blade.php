@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($mahasiswa)
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                Data yang Anda cari tidak ditemukan.
            </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>Absensi ID</th>
                        <td>{{ $mahasiswa->absensi_id }}</td>
                    </tr>
                    <tr>
                        <th>NIM</th>
                        <td>{{ $mahasiswa->mahasiswa->nim }}</td>
                    </tr>
                    <tr>
                        <th>Nama Mahasiswa</th>
                        <td>{{ $mahasiswa->mahasiswa->mahasiswa_nama }}</td>
                    </tr>
                    <tr>
                        <th>Periode Tahun</th>
                        <td>{{ $mahasiswa->periode->periode_tahun }}</td>
                    </tr>
                    <tr>
                        <th>Alpha</th>
                        <td>{{ $mahasiswa->alpha }}</td>
                    </tr>
                    <tr>
                        <th>Poin</th>
                        <td>{{ $mahasiswa->poin }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $mahasiswa->status }}</td>
                    </tr>
                </table>
            @endif
            <a href="{{ url('mahasiswa') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        </div>
    </div>
@endsection
