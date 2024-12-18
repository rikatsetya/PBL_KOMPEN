@extends('layouts.template')
@section('content')
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/mahasiswa/import') }}')" class="btn btn-info">Import mahasiswa</button>
                <a href="{{ url('/mahasiswa/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export
                    mahasiswa</a>
                <a href="{{ url('/mahasiswa/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export
                    mahasiswa</a>
                <button onclick="modalAction('{{ url('/mahasiswa/create_ajax') }}')" class="btn btn-success">Tambah Data
                    (Ajax)</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-striped table-hover table-sm" id="table-mahasiswa">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Jurusan</th>
                        <th>Prodi</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }
        var tableMahasiswa;
        $(document).ready(function() {
            tableMahasiswa = $('#table-mahasiswa').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('mahasiswa/list') }}",
                    "dataType": "json",
                    "type": "POST",
                },
                columns: [{
                    data: "DT_RowIndex",
                    className: "text-center",
                    width: "5%",
                    orderable: false,
                    searchable: false
                }, {
                    data: "nim",
                    className: "",
                    width: "10%",
                    orderable: true,
                    searchable: true
                }, {
                    data: "mahasiswa_nama",
                    className: "",
                    width: "25%",
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row) {
                        return data.length > 20 ?
                            data.substr(0, 20) + '...' :
                            data;
                    }
                }, {
                    data: "jurusan",
                    className: "",
                    width: "14%",
                    orderable: true,
                    searchable: false
                }, {
                    data: "prodi",
                    className: "",
                    width: "10%",
                    orderable: true,
                    searchable: false
                }, {
                    data: "kelas",
                    className: "",
                    width: "10%",
                    orderable: true,
                    searchable: false
                }, {
                    data: "aksi",
                    className: "text-center",
                    width: "14%",
                    orderable: false,
                    searchable: false
                }]
            });
            $('#table-mahasiswa_filter input').unbind().bind().on('keyup', function(e) {
                if (e.keyCode == 13) { // enter key
                    tableMahasiswa.search(this.value).draw();
                }
            });
        });
    </script>
@endpush
