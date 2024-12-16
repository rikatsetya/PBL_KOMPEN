@empty($selesai)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                        Data yang anda cari tidak ditemukan
                    </div>
                    <a href="{{ url('/kompen_selesai') }}" class="btn btn-warning">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/kompen_selesai/' . $selesai->pengumpulan_id . '/update') }}" method="POST" id="form-edit"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Selesai Kompen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <!-- Status -->
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="terima" {{ $selesai->status == 'terima' ? 'selected' : '' }}>Terima</option>
                            <option value="tolak" {{ $selesai->status == 'tolak' ? 'selected' : '' }}>Tolak</option>
                        </select>
                        <small id="error-status" class="error-text form-text text-danger"></small>
                    </div>

                    <!-- Alasan (only if status is "tolak") -->
                    <div class="form-group" id="alasan-container" style="display: {{ $selesai->status == 'tolak' ? 'block' : 'none' }};">
                        <label>Alasan</label>
                        <input type="text" name="alasan" id="alasan" class="form-control"
                            value="{{ old('alasan', $selesai->alasan) }}" required>
                        <small id="error-alasan" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function () {
            // Handle status change to show alasan input if "tolak"
            $('#status').change(function () {
                if ($(this).val() == 'tolak') {
                    $('#alasan-container').show();
                } else {
                    $('#alasan-container').hide();
                }
            });

            // Initialize form validation
            $("#form-edit").validate({
                rules: {
                    status: {
                        required: true,
                        minlength: 1
                    },
                    alasan: {
                        required: function (element) {
                            return $('#status').val() == 'tolak';
                        },
                        maxlength: 255
                    }
                },
                submitHandler: function (form) {
                    var formData = new FormData(form); // Use FormData to handle file uploads
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: formData,
                        contentType: false, // Let the browser set the content-type
                        processData: false, // Don't let jQuery process the data
                        success: function (response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                tableKompenSelesai.ajax.reload();
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function (prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endempty
