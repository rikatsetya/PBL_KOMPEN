@extends('layouts.template')
@section('content')
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
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
                        <label class="col-1 control-label col-form-label">Pembuat:</label>
                        <div class="col-4">
                            <select class="form-control" id="level_id" name="level_id" required>
                                <option value="">- Semua -</option>
                                @foreach ($level as $item)
                                    @if ($item->level_id != 5)
                                        <option value="{{ $item->level_id }}">{{ $item->level_nama }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Pembuat Tugas (Admin, Dosen, Tendik)</small>
                        </div>
                        <label class="col-1 control-label col-form-label">Jenis:</label>
                        <div class="col-4">
                            <select class="form-control" id="jenis_id" name="jenis_id" required>
                                <option value="">- Semua -</option>
                                @foreach ($jenis as $item)
                                        <option value="{{ $item->jenis_id }}">{{ $item->jenis_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Jenis Tugas</small>
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
                        <th>Kuota</th>
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
        var tableListTugas;
        $(document).ready(function() {
            tableListTugas = $('#table-daftar_tugas').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('daftar_tugas/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.level_id = $('#level_id').val();
                        d.jenis_id = $('#jenis_id').val();
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
                    orderable: false,
                    searchable: false
                }, {
                    data: "user.nama",
                    className: "",
                    width: "15%",
                    orderable: false,
                    searchable: false,
                }, {
                    data: "tugas_nama",
                    className: "",
                    width: "25%",
                    orderable: false,
                    searchable: true,
                    render: function(data, type, row) {
                        return data.length > 30 ?
                            data.substr(0, 30) + '...' :
                            data;
                    }
                }, {
                    data: "tugas_bobot",
                    className: "",
                    width: "10%",
                    orderable: true,
                    searchable: false,
                }, {
                    data: "kuota",
                    className: "",
                    width: "7%",
                    orderable: true,
                    searchable: false,
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
                    tableListTugas.search(this.value).draw();
                }
            });
            $('#level_id').change(function() {
                tableListTugas.draw();
            });
            $('#jenis_id').change(function() {
                tableListTugas.draw();
            });
        });
    </script>
@endpush
