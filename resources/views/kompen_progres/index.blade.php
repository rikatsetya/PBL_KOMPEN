@extends('layouts.template')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Update Kompen Progres Tugas</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-sm table-striped table-hover" id="table_kompen_progres">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Tugas</th>
                        <th>Nama Mahasiswa</th>
                        <th>Foto Sebelum</th>
                        <th>Foto Sesudah</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <!-- Modal for updating the photos -->
    <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%"></div>
@endsection

@push('js')
    <script>
        // Function to handle the modal action
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }
        var tableKompenProgres;
        $(document).ready(function() {
            tableKompenProgres = $('#table_kompen_progres').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('/kompen_progres/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d._token = '{{ csrf_token() }}'; // Menambahkan token CSRF
                    },
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "text-center",
                        width: "5%",
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: "tugas_nama",
                        className: "",
                        width: "25%",
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: "mahasiswa_nama",
                        className: "",
                        width: "20%",
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: "foto_sebelum",
                        className: "text-center",
                        width: "15%",
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return data ?
                                `<img src="{{ asset('foto_sebelum/${data}') }}" class="img-thumbnail" width="100" height="100">` :
                                'No Image';
                        }
                    },
                    {
                        data: "foto_sesudah",
                        className: "text-center",
                        width: "15%",
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return data ?
                                `<img src="{{ asset('foto_sesudah/${data}') }}" class="img-thumbnail" width="100" height="100">` :
                                'No Image';
                        }
                    },
                    {
                        data: "tanggal",
                        className: "",
                        width: "15%",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "aksi",
                        className: "text-center",
                        width: "15%",
                        orderable: false,
                        searchable: false,
                    }
                ]
            });
            // Search functionality on enter key
            $('#table_kompen_progres_filter input').unbind().bind('keyup', function(e) {
                if (e.keyCode == 13) { // enter key
                    tableKompenProgres.search(this.value).draw();
                }
            });
        });
    </script>
@endpush