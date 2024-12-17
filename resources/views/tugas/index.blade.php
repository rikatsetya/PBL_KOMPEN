@extends('layouts.template')
@section('content')
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/manage_tugas/create_ajax') }}')" class="btn btn-success">Tambah Data
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
            <table class="table table-bordered table-striped table-hover table-sm" id="table-tugas">
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
    <!-- Tambahkan CSS tambahan jika diperlukan -->
@endpush

@push('js')
    <script>
        // Fungsi untuk memuat modal
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

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
@endpush
