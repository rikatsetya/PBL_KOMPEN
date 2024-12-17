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
            <table class="table table-bordered table-striped table-hover table-sm" id="table-hasil">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Tugas</th>
                        <th>Nama Mahasiswa</th>
                        <th>Foto Sebelum</th>
                        <th>Foto Sesudah</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Alasan</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    </div>
@endsection
@push('css')
@endpush

@push('js')
    <script>
        var tableKompenSelesai;
        $(document).ready(function() {
            tableKompenSelesai = $('#table-hasil').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('/kompen_selesaim/list') }}", // Pastikan URL ini sesuai dengan controller
                    "dataType": "json",
                    "type": "POST"
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
                        data: "alasan",
                        className: "text-left",
                        width: "20%",
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return data ? data : '-';
                        }
                    }
                ]
            });

            // Search functionality on enter key
            $('#table-hasil_filter input').unbind().bind('keyup', function(e) {
                if (e.keyCode == 13) { // enter key
                    tableKompenSelesai.search(this.value).draw();
                }
            });
        });
    </script>
@endpush
