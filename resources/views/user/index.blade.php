@extends('layouts.template')
@section('content')
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/user/import') }}')" class="btn btn-info btn-sm">Import Absensi</button>
                <a href="{{ url('/user/export_excel') }}" class="btn btn-primary btn-sm"><i class="fa fa-file-excel"></i> Export Absensi</a>
                <a href="{{ url('/user/export_pdf') }}" class="btn btn-warning btn-sm"><i class="fa fa-file-pdf"></i> Export Absensi</a>
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
                        <th>ID</th>
                        <th>Mahasiswa ID</th>
                        <th>Nama Mahasiswa</th>
                        <th>Sakit</th>
                        <th>Izin</th>
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
                serverSide: true,
                ajax: {
                    "url": "{{ url('user/list') }}",
                    "dataType": "json",
                    "type": "POST"
                    // tidak perlu data dibawah karena tidak ada filter
                    // "data": function (d) {
                    //     d.supplier_id = $('#supplier_id').val();
                    // }
                },
                columns: [{
                    // nomor urut dari laravel datatable addIndexColumn()
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }, {
                    data: "mahasiswa.mahasiswa_id",
                    className: "",
                    // orderable: true, jika ingin kolom ini bisa diurutkan
                    orderable: true,
                    // searchable: true, jika ingin kolom ini bisa dicari
                    searchable: true
                }, {
                    data: "mahasiswa.mahasiswa_nama",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "sakit",
                    className: "",
                    orderable: false,
                    searchable: false
                }, {
                    data: "izin",
                    className: "",
                    orderable: false,
                    searchable: false
                }, {
                    data: "alpha",
                    className: "",
                    orderable: false,
                    searchable: false
                }, {
                    data: "poin",
                    className: "",
                    orderable: false,
                    searchable: false
                }, {
                    data: "status",
                    className: "",
                    orderable: false,
                    searchable: false
                }, {
                    data: "periode",
                    className: "",
                    orderable: false,
                    searchable: false
                }, {
                    data: "aksi",
                    className: "",
                    orderable: false,
                    searchable: false
                }]
            });

            // $('#supplier_id').on('change',function(){
            //     datasupplier.ajax.reload();
            // });
        });
    </script>
@endpush
