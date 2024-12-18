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
                    <label class="col-1 control-label col-form-label">Filter:</label>
                    <!-- Filter Status -->
                    <div class="col-3">
                        <select class="form-control" id="status" name="status" required>
                            <option value="">- Semua Status -</option>
                            <option value="Lunas">Lunas</option>
                            <option value="Belum Lunas">Belum Lunas</option>
                        </select>
                        <small class="form-text text-muted">Status</small>
                    </div>
                    <!-- Filter Periode -->
                    <div class="col-3">
                        <select class="form-control" id="periode_id" name="periode_id" required>
                            <option value="">- Semua Periode -</option>
                            @foreach ($periode as $item)
                            <option value="{{ $item->periode_id }}">{{ $item->periode_tahun }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Periode</small>
                    </div>
                    <!-- Filter Search -->
                    <form class="col-4 d-flex gap-2" id="header-search-form">
                        <input class="form-control" type="text" placeholder="Search" id="header-search-input" />
                        <button type="submit" class="btn btn-primary mb-auto">Search</button>
                    </form>
                </div>
            </div>
        </div>
        <table class="table table-bordered table-striped table-hover table-sm" id="table-hasil">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nim</th>
                    <th>Nama Mahasiswa</th>
                    <th>Poin</th>
                    <th>Status</th>
                    <th>Periode</th>
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
    var tableHasil;
    $(document).ready(function() {
        const params = new URLSearchParams(window.location.search);
        const searchQuery = params.get("search");
        $('#header-search-input').val(searchQuery)

        tableHasil = $('#table-hasil').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ url('hasil/list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function(d) {
                    // Pass the status and periode_id to the server-side
                    d.status = $('#status').val();
                    d.periode_id = $('#periode_id').val();
                    d.surat_uuid = searchQuery;
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
                    data: "mahasiswa.nim",
                    className: "",
                    width: "10%",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "mahasiswa.mahasiswa_nama",
                    className: "",
                    width: "25%",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "poin",
                    className: "",
                    width: "14%",
                    orderable: true,
                    searchable: false
                },
                {
                    data: "status",
                    className: "",
                    width: "14%",
                    orderable: true,
                    searchable: false
                },
                {
                    data: "periode.periode_tahun",
                    className: "",
                    width: "14%",
                    orderable: true,
                    searchable: false
                },
                {
                    data: "aksi",
                    className: "text-center",
                    width: "14%",
                    orderable: false,
                    searchable: false
                }
            ]
        });
<<<<<<< HEAD
    </script>
<<<<<<< HEAD
@endpush
=======
@endpush
>>>>>>> 0916f1e641e08abb12c4e55b5e84393c72c4d7e5
=======

        // Reload the DataTable when the filters are changed
        $('#status, #periode_id').change(function() {
            tableHasil.draw();
        });

        // Search function
        $('#header-search-form').on('submit', (event) => {
            event.preventDefault() // Prevent the default form submission
            const baseURL = `${window.location.origin}${window.location.pathname}` // Get the base URL
            const searchQuery = $('#header-search-input').val() // Use jQuery to get the input value
            const newURL = searchQuery ? `${baseURL}?search=${encodeURIComponent(searchQuery)}` : baseURL // Build the new URL
            window.location.href = newURL // Redirect to the new URL
        })
    });
</script>
@endpush
>>>>>>> 891245d9ac3e594ce7fcb33e2fe76f97c000ef58
