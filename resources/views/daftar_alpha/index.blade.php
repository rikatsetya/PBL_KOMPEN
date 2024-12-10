@extends('layouts.template')
@section('content')
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/daftar_alpha/import') }}')" class="btn btn-info btn-sm">Import Absensi</button>
                <a href="{{ url('/daftar_alpha/export_excel') }}" class="btn btn-primary btn-sm"><i class="fa fa-file-excel"></i> Export Absensi</a>
                <a href="{{ url('/daftar_alpha/export_pdf') }}" class="btn btn-warning btn-sm"><i class="fa fa-file-pdf"></i> Export Absensi</a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-striped table-hover table-sm" id="table_absensi">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Alpha</th>
                        <th>Poin</th>
                        <th>Status</th>
                        <th>Periode</th>
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

        var dataabsensi;
        $(document).ready(function() {
            dataabsensi = $('#table_absensi').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('daftar_alpha/list') }}",
                    "dataType": "json",
                    "type": "POST"
                },
                columns: [{
                    // nomor urut dari laravel datatable addIndexColumn()
                    data: "DT_RowIndex",
                    className: "text-center",
                    width: "6%",
                    orderable: false,
                    searchable: false
                }, {
                    data: "mahasiswa.nim",
                    className: "",
                    width: "10%",
                    orderable: true,
                    searchable: true
                }, {
                    data: "mahasiswa.mahasiswa_nama",
                    className: "",
                    width: "25%",
                    orderable: true,
                    searchable: true
                }, {
                    data: "alpha",
                    className: "",
                    width: "5%",
                    orderable: false,
                    searchable: false
                }, {
                    data: "poin",
                    className: "",
                    width: "5%",
                    orderable: false,
                    searchable: false
                }, {
                    data: "status",
                    className: "",
                    width: "10%",
                    orderable: false,
                    searchable: true
                }, {
                    data: "periode.periode_tahun",
                    className: "",
                    width: "10%",
                    orderable: false,
                    searchable: false
                }, {
                    data: "aksi",
                    className: "",
                    width: "7%",
                    orderable: false,
                    searchable: false
                }]
            });
            $('#table-daftar_tugas_filter input').unbind().bind().on('keyup', function(e) {
                if (e.keyCode == 13) { // enter key
                    dataabsensi.search(this.value).draw();
                }
            });
        });
    </script>
@endpush