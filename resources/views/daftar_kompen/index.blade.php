@extends('layouts.template')
@section('content')
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a href="{{ url('/daftar_kompen/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export
                    mahasiswa</a>
                <a href="{{ url('/daftar_kompen/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export
                    mahasiswa</a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
<<<<<<< HEAD
=======
            <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select class="form-control" id="mahasiswa_id" name="mahasiswa_id" required>
                                <option value="">- Semua -</option>
                                @foreach ($mahasiswa as $item)
                                    <option value="{{ $item->mahasiswa_id }}">{{ $item->mahasiswa_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">mahasiswa</small>
                        </div>
                    </div>
                </div>
            </div>
>>>>>>> 0916f1e641e08abb12c4e55b5e84393c72c4d7e5
            <table class="table table-bordered table-striped table-hover table-sm" id="table-kompen">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nim</th>
                        <th>Nama Mahasiswa</th>
                        <th>Poin</th>
                        <th>Status</th>
                        <th>Periode</th>
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
        var tableKompen;
        $(document).ready(function() {
            tableKompen = $('#table-kompen').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('daftar_kompen/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.mahasiswa_id = $('#mahasiswa_id').val();
                    }
                },
                columns: [{
                    data: "DT_RowIndex",
                    className: "text-center",
                    width: "5%",
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
                    searchable: true,
                }, {
                    data: "poin",
                    className: "",
                    width: "14%",
                    orderable: true,
                    searchable: false
                }, {
                    data: "status",
                    className: "",
                    width: "14%",
                    orderable: true,
                    searchable: false
                },{
                    data: "periode.periode_tahun",
                    className: "",
                    width: "14%",
                    orderable: true,
                    searchable: false
                }]
            });
            $('#table-kompen_filter input').unbind().bind().on('keyup', function(e) {
                if (e.keyCode == 13) { // enter key
                    tableKompen.search(this.value).draw();
                }
            });
            $('#mahasiswa_id').change(function() {
                tableKompen.draw();
            });
        });
    </script>
<<<<<<< HEAD
@endpush
=======
@endpush
>>>>>>> 0916f1e641e08abb12c4e55b5e84393c72c4d7e5
