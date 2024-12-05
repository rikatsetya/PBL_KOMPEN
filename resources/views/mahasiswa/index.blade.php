@extends('layouts.template')

@section('content')
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a href="{{ url('/mahasiswa/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i>Export user</a>
                <a href="{{ url('/mahasiswa/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export user</a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-striped table-hover table-sm" id="table_mahasiswa">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Poin</th>
                        <th>Periode</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
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

        var datamahasiswa;
        $(document).ready(function() {
            datamahasiswa = $('#table_mahasiswa').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    "url": "{{ url('mahasiswa/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.mahasiswa_id = $('#mahasiswa_id').val();
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "mahasiswa.nim",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "mahasiswa.mahasiswa_nama",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "poin",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "periode", // Gunakan "periode" di sini, karena ini yang ditambahkan di controller
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "aksi",
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            $('#table-mahasiswa_filter input').unbind().bind().on('keyup', function(e) {
                if (e.keyCode == 13) { // enter key
                    tableUser.search(this.value).draw();
                }
            });
            $('#mahasiswa_id').on('change', function() {
                datamahasiswa.ajax.reload();
            });
        });
    </script>
@endpush
