@extends('layouts.template')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Periode</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/periode/create_ajax') }}')" class="btn btn-success">Tambah Data
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
            <table class="table table-bordered table-sm table-striped table-hover" id="table_periode">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tahun periode</th>
                        <th>Semester</th>
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
        var tablePeriode;
        $(document).ready(function() {
            tablePeriode = $('#table_periode').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('/periode/list') }}",
                    "dataType": "json",
                    "type": "POST",
                },
                columns: [{
                    data: "DT_RowIndex",
                    className: "text-center",
                    width: "5%",
                    orderable: false,
                    searchable: false
                },{
                    data: "periode_tahun",
                    className: "",
                    width: "37%",
                    orderable: true,
                    searchable: true,
                }, {
                    data: "periode_semester",
                    className: "",
                    width: "37%",
                    orderable: false,
                    searchable: false,
                }, {
                    data: "aksi",
                    className: "text-center",
                    width: "14%",
                    orderable: false,
                    searchable: false
                }]
            });
            $('#table_periode_filter input').unbind().bind().on('keyup', function(e) {
                if (e.keyCode == 13) { // enter key
                    tablePeriode.search(this.value).draw();
                }
            });
        });
    </script>
@endpush