@extends('layouts.template')
@section('content')
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
<<<<<<< HEAD
                <button onclick="modalAction('{{ url('/manage_tugas/create_ajax') }}')" class="btn btn-success">Tambah Data
=======
                <button onclick="modalAction('{{ url('/tugas/create_ajax') }}')" class="btn btn-success">Tambah Data
>>>>>>> 0916f1e641e08abb12c4e55b5e84393c72c4d7e5
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
<<<<<<< HEAD
=======
            <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2" style="display: none">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label" >Filter:</label>
                        <div class="col-3">
                            <select class="form-control" id="level_id" name="level_id" required>
                                <option value="">- Semua -</option>
                                @foreach ($user as $item)
                                <option {{ $item->level_id == session('level_id') ? 'selected' : '' }}
                                    value="{{ $item->level_id }}">{{ $item->level_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Pembuat Tugas (Admin, Dosen, Tendik)</small>
                        </div>
                    </div>
                </div>
            </div>
>>>>>>> 0916f1e641e08abb12c4e55b5e84393c72c4d7e5
            <table class="table table-bordered table-striped table-hover table-sm" id="table-tugas">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Tugas</th>
                        <th>Pembuat</th>
                        <th>Nama Tugas</th>
                        <th>Bobot Tugas</th>
<<<<<<< HEAD
                        <th>Kuota</th>
=======
>>>>>>> 0916f1e641e08abb12c4e55b5e84393c72c4d7e5
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
<<<<<<< HEAD

@push('css')
    <!-- Tambahkan CSS tambahan jika diperlukan -->
@endpush

@push('js')
    <script>
        // Fungsi untuk memuat modal
=======
@push('css')
@endpush
@push('js')
    <script>
>>>>>>> 0916f1e641e08abb12c4e55b5e84393c72c4d7e5
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }
<<<<<<< HEAD

        var tableTugas;
        $(document).ready(function() {
            // DataTable initialization
            tableTugas = $('#table-tugas').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ url('manage_tugas/list') }}",  // URL endpoint untuk mengambil data tugas
                    type: "POST",  // Menggunakan metode POST
                    dataType: "json",  // Format data yang diterima adalah JSON
                    data: function(d) {
                        d.level_id = $('#level_id').val();  // Mengirimkan level_id ke server
                    },
                    error: function(xhr, error, thrown) {
                        console.error('Error AJAX:', error);  // Menangani error AJAX
                    }
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", width: "5%", orderable: false, searchable: false },
                    { data: "jenis.jenis_nama", className: "text-center", width: "10%", orderable: true, searchable: true },
                    { data: "user.nama", className: "", width: "15%", orderable: false, searchable: true },
                    { data: "tugas_nama", className: "", width: "25%", orderable: false, searchable: true },
                    { data: "tugas_bobot", className: "text-center", width: "10%", orderable: true, searchable: true },
                    { data: "kuota", className: "text-center", width: "10%", orderable: true, searchable: true },
                    { data: "aksi", className: "text-center", width: "10%", orderable: false, searchable: false }
                ]
            });

            // Menambahkan event ketika filter level_id diubah
=======
        var tableTugas;
        $(document).ready(function() {
            tableTugas = $('#table-tugas').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('tugas/list') }}",
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
                    width: "15%",
                    orderable: false,
                    searchable: false
                }]
            });
>>>>>>> 0916f1e641e08abb12c4e55b5e84393c72c4d7e5
            $('#table-tugas_filter input').unbind().bind().on('keyup', function(e) {
                if (e.keyCode == 13) { // enter key
                    tableTugas.search(this.value).draw();
                }
            });
            $('#level_id').change(function() {
                tableTugas.draw();
            });
        });
    </script>
<<<<<<< HEAD
@endpush
=======
@endpush
>>>>>>> 0916f1e641e08abb12c4e55b5e84393c72c4d7e5
