@extends('layouts.template')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar kompetensi</h3>
            <div class="card-tools">
<<<<<<< HEAD
=======
                <button onclick="modalAction('{{ url('/kompetensi/import') }}')" class="btn btn-info">Import kompetensi</button>
                <a href="{{ url('/kompetensi/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export kompetensi</a>
                <a href="{{ url('/kompetensi/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export kompetensi</a>
>>>>>>> 0916f1e641e08abb12c4e55b5e84393c72c4d7e5
                <button onclick="modalAction('{{ url('/kompetensi/create_ajax') }}')" class="btn btn-success">Tambah Data
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
            <table class="table table-bordered table-sm table-striped table-hover" id="table_kompetensi">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama kompetensi</th>
                        <th>Deskripsi</th>
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
        var tableKompetensi;
        $(document).ready(function() {
            tableKompetensi = $('#table_kompetensi').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('/kompetensi/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.filter_kategori = $('.filter_kategori').val();
                    }
                },
                columns: [{
                    data: "DT_RowIndex",
                    className: "text-center",
                    width: "5%",
                    orderable: false,
                    searchable: false
<<<<<<< HEAD
                }, {
=======
                },{
>>>>>>> 0916f1e641e08abb12c4e55b5e84393c72c4d7e5
                    data: "kompetensi_nama",
                    className: "",
                    width: "10%",
                    orderable: true,
<<<<<<< HEAD
                    searchable: true,
                    render: function(data, type, row) {
                        return data.length > 10 ?
                            data.substr(0, 10) + '...' :
                            data;
                    }
=======
                    searchable: true
>>>>>>> 0916f1e641e08abb12c4e55b5e84393c72c4d7e5
                }, {
                    data: "kompetensi_deskripsi",
                    className: "",
                    width: "37%",
                    orderable: true,
                    searchable: true,
<<<<<<< HEAD
                    render: function(data, type, row) {
                        return data.length > 40 ?
                            data.substr(0, 40) + '...' :
                            data;
                    }
=======
>>>>>>> 0916f1e641e08abb12c4e55b5e84393c72c4d7e5
                }, {
                    data: "aksi",
                    className: "text-center",
                    width: "14%",
                    orderable: false,
                    searchable: false
                }]
            });
            $('#table_kompetensi_filter input').unbind().bind().on('keyup', function(e) {
                if (e.keyCode == 13) { // enter key
                    tableKompetensi.search(this.value).draw();
                }
            });
        });
    </script>
<<<<<<< HEAD
@endpush
=======
@endpush
>>>>>>> 0916f1e641e08abb12c4e55b5e84393c72c4d7e5
