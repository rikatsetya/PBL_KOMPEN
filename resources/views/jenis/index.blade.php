@extends('layouts.template')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Jenis Tugas</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/jenis/create_ajax') }}')" class="btn btn-success">Tambah Data
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
            <table class="table table-bordered table-sm table-striped table-hover" id="table_jenis">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Jenis Tugas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false"
        data-width="75%"></div>
@endsection
@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }
        var tableJenis;
        $(document).ready(function() {
            tableJenis = $('#table_jenis').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('/jenis/list') }}",
                    "dataType": "json",
                    "type": "POST"
                },
                columns: [{
                    data: "DT_RowIndex",
                    className: "text-center",
                    width: "5%",
                    orderable: false,
                    searchable: false
                },{
                    data: "jenis_nama",
                    className: "",
                    width: "37%",
                    orderable: true,
                    searchable: true,
                }, {
                    data: "aksi",
                    className: "text-center",
                    width: "14%",
                    orderable: false,
                    searchable: false
                }]
            });
            $('#table_jenis_filter input').unbind().bind().on('keyup', function(e) {
                if (e.keyCode == 13) { // enter key
                    tableJenis.search(this.value).draw();
                }
            });
        });
    </script>
@endpush