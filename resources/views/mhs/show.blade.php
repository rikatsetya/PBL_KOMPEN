{{-- @extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
        </div>
        <div class="card-body">
            @if (!$mhs)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>Nama Mahasiswa</th>
                        <td>{{ $mhs->mahasiswa->mahasiswa_nama ?? 'Tidak tersedia' }}</td>
                    </tr>

                    <tr>
                        <th>Sakit</th>
                        <td>{{ $mhs->sakit }}</td>
                    </tr>

                    <tr>
                        <th>Izin</th>
                        <td>{{ $mhs->izin }}</td>
                    </tr>

                    <tr>
                        <th>Alpha</th>
                        <td>{{ $mhs->alpha }}</td>
                    </tr>

                    <tr>
                        <th>Poin</th>
                        <td>{{ $mhs->poin }}</td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td>{{ $mhs->status }}</td>
                    </tr>

                    <tr>
                        <th>Periode</th>
                        <td>{{ $mhs->periode }}</td>
                    </tr>
                </table>
            @endif
            <a href="{{ url('mhs') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        </div>
    </div>
@endsection --}}

@empty($mhs)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/mhs') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail data Mahasiswa Kompen</h5>
                <button type="button" class="close" data-dismiss="modal" aria label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>Nama Mahasiswa</th>
                        <td>{{ $mhs->mahasiswa->mahasiswa_nama ?? 'Tidak tersedia' }}</td>
                    </tr>

                    <tr>
                        <th>Sakit</th>
                        <td>{{ $mhs->sakit }}</td>
                    </tr>

                    <tr>
                        <th>Izin</th>
                        <td>{{ $mhs->izin }}</td>
                    </tr>

                    <tr>
                        <th>Alpha</th>
                        <td>{{ $mhs->alpha }}</td>
                    </tr>

                    <tr>
                        <th>Poin</th>
                        <td>{{ $mhs->poin }}</td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td>{{ $mhs->status }}</td>
                    </tr>

                    <tr>
                        <th>Periode</th>
                        <td>{{ $mhs->periode }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Kembali</button>
            </div>
        </div>
    </div>
@endempty