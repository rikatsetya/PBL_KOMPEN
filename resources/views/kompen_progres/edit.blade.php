@empty($progres)
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
                    <a href="{{ url('/kompen_progres') }}" class="btn btn-warning">Kembali</a>
                </div>
            </div>
        </div>
    @else
        <form action="{{ url('/kompen_progres/' . $progres->pengumpulan_id . '/update') }}" method="POST" id="form-edit"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div id="modal-master" class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Progres Kompen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Foto Sebelum</label>
                            <input type="file" name="foto_sebelum" id="foto_sebelum" class="form-control"
                                accept=".png,.jpg,.jpeg">
                            <small id="error-foto" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Foto Sesudah</label>
                            <input type="file" name="foto_sesudah" id="foto_sesudah" class="form-control"
                                accept=".png,.jpg,.jpeg">
                            <small id="error-foto" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
        </form>
        <script>
            $(document).ready(function() {
                $("#form-edit").validate({
                    rules: {
                        foto_sebelum: {
                            required: false,
                            accept: "png,jpg,jpeg"
                        },
                        foto_sesudah: {
                            required: false,
                            accept: "png,jpg,jpeg"
                        }
                    },
                    submitHandler: function(form) {
                        var formData = new FormData(form); // Use FormData to handle file uploads
                        if (formData.has('foto_sebelum') || formData.has('foto_sesudah')) {
                            $.ajax({
                                url: form.action,
                                type: form.method,
                                data: formData,
                                contentType: false, // Let the browser set the content-type
                                processData: false, // Don't let jQuery process the data
                                success: function(response) {
                                    if (response.status) {
                                        $('#myModal').modal('hide');
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil',
                                            text: response.message
                                        });
                                        tableKompenProgres.ajax.reload();
                                    } else {
                                        $('.error-text').text('');
                                        $.each(response.msgField, function(prefix, val) {
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
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'File foto sebelum atau sesudah harus diunggah!'
                            });
                        }
                        return false;
                    },
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    }
                });
            });
        </script>
    @endempty
