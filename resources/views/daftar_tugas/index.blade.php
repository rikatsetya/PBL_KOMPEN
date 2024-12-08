@extends('layouts.template')
@section('content')
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            {{-- <div class="card-tools">
                <button onclick="modalAction('{{ url('/daftar_tugas/import') }}')" class="btn btn-info">Import user</button>
                <a href="{{ url('/daftar_tugas/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export
                    user</a>
                <a href="{{ url('/daftar_tugas/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export
                    user</a>
                <button onclick="modalAction('{{ url('/daftar_tugas/create_ajax') }}')" class="btn btn-success">Tambah Data
                    (Ajax)</button>
            </div> --}}
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select class="form-control" id="level_id" name="level_id" required>
                                <option value="">- Semua -</option>
                                @foreach ($user as $item)
                                    <option value="{{ $item->level_id }}">{{ $item->level->level_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Pembuat Tugas (Admin, Dosen, Tendik)</small>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table-daftar_tugas">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Tugas</th>
                        <th>Pembuat</th>
                        <th>Nama Tugas</th>
                        <th>Bobot Tugas</th>
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
        var tableUser;
        $(document).ready(function() {
            tableUser = $('#table-daftar_tugas').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('daftar_tugas/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.level_id = $('#level_id').val();
                    }
                },
                columns: [{
                    data: "DT_RowIndex",
                    className: "text-center",
                    width: "5%",
                    orderable: false,
                    searchable: false
                }, {
                    data: "jenis.jenis_nama",
                    className: "",
                    width: "10%",
                    orderable: true,
                    searchable: true
                }, {
                    data: "user.nama",
                    className: "",
                    width: "15%",
                    orderable: true,
                    searchable: true,
                }, {
                    data: "tugas_nama",
                    className: "",
                    width: "25%",
                    orderable: true,
                    searchable: false
                }, {
                    data: "tugas_bobot",
                    className: "",
                    width: "10%",
                    orderable: false,
                    searchable: true,
                }, {
                    data: "aksi",
                    className: "text-center",
                    width: "10%",
                    orderable: false,
                    searchable: false
                }]
            });
            $('#table-daftar_tugas_filter input').unbind().bind().on('keyup', function(e) {
                if (e.keyCode == 13) { // enter key
                    tableUser.search(this.value).draw();
                }
            });
            $('#level_id').change(function() {
                tableUser.draw();
            });
        });
    </script>
@endpush
