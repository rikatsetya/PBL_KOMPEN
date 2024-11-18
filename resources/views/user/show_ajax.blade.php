<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
                <tr>
                    <th>NIM</th>
                    <td>{{ $absensi->mahasiswa->nim ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Nama Mahasiswa</th>
                    <td>{{ $absensi->mahasiswa->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Sakit</th>
                    <td>{{ $absensi->sakit ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Izin</th>
                    <td>{{ $absensi->izin ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Alpha</th>
                    <td>{{ $absensi->alpha ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Poin</th>
                    <td>{{ $absensi->poin ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $absensi->status ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Periode</th>
                    <td>{{ $absensi->periode ?? '-' }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>

<script>
    function modalAction(url) {
    $.ajax({
        url: url,
        type: 'GET',
        success: function(response) {
            if (response.status) {
                $('#myModal').html(response.data).modal('show');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message,
                });
            }
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: xhr.responseJSON?.message || 'An unexpected error occurred.',
            });
        },
    });
}

// columns: [
//     { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
//     { data: "mahasiswa.mahasiswa_id", className: "", orderable: true, searchable: true },
//     { data: "mahasiswa.mahasiswa_nama", className: "", orderable: true, searchable: true },
//     { data: "sakit", className: "", orderable: false, searchable: false },
//     { data: "izin", className: "", orderable: false, searchable: false },
//     { data: "alpha", className: "", orderable: false, searchable: false },
//     { data: "poin", className: "", orderable: false, searchable: false },
//     { data: "status", className: "", orderable: false, searchable: false },
//     { data: "periode", className: "", orderable: false, searchable: false },
//     { 
//         data: "aksi", 
//         className: "text-center", 
//         orderable: false, 
//         searchable: false,
//         render: function(data, type, row) {
//             return `<button onclick="modalAction('${row.show_url}')" class="btn btn-primary btn-sm">View</button>`;
//         }
//     }
// ]

</script>