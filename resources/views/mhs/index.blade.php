@extends('layouts.template')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Mahasiswa Kompen</h3>
            <div class="card-tools">
                {{-- <button onclick="modalAction('{{ url('/mhs/import') }}')" class="btn btn-info">Import Daftar</button> --}}
                <a href="{{ url('/mhs/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export Daftar</a>
                <a href="{{ url('/mhs/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export Daftar</a>
                {{-- <button onclick="modalAction('{{ url('/mhs/create_ajax') }}')" class="btn btn-success">Tambah Data (Ajax)</button> --}}
            </div>
        </div>
        <div class="card-body">
            <div id="filter" class="form-horizontal p-2 border-bottom mb-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row text-sm mb-0">
                            <label for="filter_date" class="col-md-1 col-form-label">Filter</label>
                            <div class="col-md-3">
                                <select name="filter_mahasiswa" class="form-control filter_mahasiswa">
                                    <option value="">- Semua -</option>
                                    @foreach ($mahasiswa as $m)
                                        <option value="{{ $m->mahasiswa_id }}">{{ $m->mahasiswa_nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pesan sukses atau error -->
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Tabel -->
            <table class="table table-bordered table-sm" id="table-mhs">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Mahasiswa</th>
                        <th>Alpha</th>
                        <th>Poin</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false"></div>
@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        $(document).ready(function() {
            var tablemhs = $('#table-mhs').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('mhs/list') }}",
                    type: "POST",
                    data: function(d) {
                        d.filter_mahasiswa = $('.filter_mahasiswa').val();
                    }
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", orderable: false },
                    { data: "mahasiswa.mahasiswa_nama", orderable: true },
                    { data: "alpha", orderable: true },
                    { data: "poin", orderable: true },
                    { data: "status", orderable: true },
                    { data: "aksi", className: "text-center", orderable: false }
                ]
            });

            $('.filter_mahasiswa').change(function() {
                tablemhs.draw();
            });
        });
    </script>
@endpush