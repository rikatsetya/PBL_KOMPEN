@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($daftar_tugas)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table table-sm table-bordered table-striped">
                    <tr>
                        <th class="text-right col-3">ID</th>
                        <td class="col-9">{{ $daftar_tugas->tugas_id }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Jenis Tugas</th>
                        <td class="col-9">{{ $daftar_tugas->jenis->jenis_nama }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Pembuat Tugas</th>
                        <td class="col-9">{{ $daftar_tugas->user->nama }} ({{ $daftar_tugas->user->level->level_nama }})</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Nama Tugas</th>
                        <td class="col-9">{{ $daftar_tugas->tugas_nama }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Deskripsi Tugas</th>
                        <td class="col-9">{{ $daftar_tugas->deskripsi }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Bobot Tugas</th>
                        <td class="col-9">{{ $daftar_tugas->tugas_bobot }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Tenggat Tugas</th>
                        <td class="col-9">{{ $daftar_tugas->tugas_tenggat }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Periode Tugas</th>
                        <td class="col-9">{{ $daftar_tugas->periode }}</td>
                    </tr>
                </table>
            @endempty
            <a href="{{ url('daftar_tugas') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
@endpush
