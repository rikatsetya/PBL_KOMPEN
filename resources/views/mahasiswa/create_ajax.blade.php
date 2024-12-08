<form action="{{ url('/mahasiswa/ajax') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data mahasiswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Username</label>
                    <input value="" type="text" name="username" id="username" class="form-control" required>
                    <small id="error-username" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nama Mahasiswa</label>
                    <input value="" type="text" name="mahasiswa_nama" id="mahasiswa_nama" class="form-control"
                        required>
                    <small id="error-nama" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>NIM</label>
                    <input value="" type="text" name="nim" id="nim" class="form-control" required>
                    <small id="error-nim" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>No Telp</label>
                    <input type="text" name="no_telp" id="no_telp" class="form-control" required>
                    <small id="error-no_telp" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Jurusan</label>
                    <select name="jurusan" id="jurusan" class="form-control" required>
                        <option value="" selected>--Select--</option>
                        <option value="Teknologi Informasi">Teknologi Informasi</option>
                    </select>
                    <small id="error-jurusan" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Prodi</label>
                    <select name="prodi" id="prodi" class="form-control" required>
                        <option value="" selected>--Select--</option>
                        <option value="Teknik Informatika">Teknik Informatika</option>
                        <option value="Sistem Informasi Bisnis">Sistem Informasi Bisnis</option>
                    </select>
                    <small id="error-prodi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Kelas</label>
                    <input value="" type="text" name="kelas" id="kelas" class="form-control"
                        placeholder="contoh: 3B, 1A" required>
                    <small id="error-kelas" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input value="" type="password" name="password" id="password" class="form-control" required>
                    <small id="error-password" class="error-text form-text text-danger"></small>
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
    $(document).ready(function() {
        $("#form-tambah").validate({
            rules: {
                username: {
                    required: true,
                    minlength: 3,
                    maxlength: 20
                },
                nama_mahasiswa: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                nim: {
                    required: true,
                    minlength: 3,
                    maxlength: 20
                },
                no_telp: {
                    required: true,
                    minlength: 3,
                    maxlength: 20,
                    number: true
                },
                jurusan: {
                    required: true,
                },
                prodi: {
                    required: true,
                },
                kelas: {
                    required: true,
                    minlength: 1,
                    maxlength: 3
                },
                password: {
                    required: true,
                    minlength: 6,
                    maxlength: 20
                },
            },
            submitHandler: function(form) {
                var formData = new FormData(
                    form);
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    processData: false, // setting processData dan contentType ke false, untuk menghandle file 
                    contentType: false,
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            tableMahasiswa.ajax.reload();
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
