@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header bg-light">
            <h3 class="card-title">Update Kompen Selesai Tugas</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-sm table-striped table-hover" id="table_kompen_selesai">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Tugas</th>
                            <th>Nama Mahasiswa</th>
                            <th>Foto Sebelum</th>
                            <th>Foto Sesudah</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for updating the photos -->
    <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false"
        data-width="75%"></div>
@endsection

@push('js')
    <script>
        // Function to handle the modal action
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var tableKompenSelesai;
        $(document).ready(function() {
            tableKompenSelesai = $('#table_kompen_selesai').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('/kompen_selesai/list') }}", // URL controller yang benar
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d._token = '{{ csrf_token() }}'; // Tambahkan token CSRF untuk keamanan
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "text-center",
                        width: "5%",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "tugas_nama",
                        className: "text-left",
                        width: "25%",
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: "mahasiswa_nama",
                        className: "text-left",
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
                                `<img src="{{ asset('foto_sebelum/${data}') }}" class="img-fluid rounded" style="max-width: 100px; max-height: 100px;">` :
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
                                `<img src="{{ asset('foto_sesudah/${data}') }}" class="img-fluid rounded" style="max-width: 100px; max-height: 100px;">` :
                                'No Image';
                        }
                    },
                    {
                        data: "tanggal",
                        className: "text-center",
                        width: "15%",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "status",
                        className: "text-center",
                        width: "15%",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "aksi",
                        className: "text-center",
                        width: "15%",
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Search functionality on enter key
            $('#table_kompen_selesai_filter input').unbind().bind('keyup', function(e) {
                if (e.keyCode == 13) { // enter key
                    tableKompenSelesai.search(this.value).draw();
                }
            });
        });
    </script>
@endpush
