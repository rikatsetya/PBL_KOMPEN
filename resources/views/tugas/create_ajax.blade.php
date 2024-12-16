<form action="{{ url('/manage_tugas/ajax') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data tugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Level Pengguna -->
                <div class="form-group">
                    <label>Pembuat</label>
                    <input name="user_id" id="user_id" class="form-control" disabled value=" --user--">
                    <small id="error-level_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Jenis Tugas</label>
                    <select name="jenis_id" id="jenis_id" class="form-control" required>
                        <option value="">- Pilih Jenis -</option>
                        @foreach($jenis as $l)
                            <option value="{{ $l->jenis_id }}">{{ $l->jenis_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-jenis_id" class="error-text form-text text-danger"></small>
                </div>
                <!-- nama tugas -->
                <div class="form-group">
                    <label>Nama Tugas</label>
                    <input type="text" name="tugas_nama" id="tugas_nama" class="form-control" required>
                    <small id="error-tugas_nama" class="error-text form-text text-danger"></small>
                </div>

                <!-- deskripsi -->
                <div class="form-group">
                    <label>Deskripsi</label>
                    <input type="text" name="deskripsi" id="deskripsi" class="form-control" required>
                    <small id="error-deskripsi" class="error-text form-text text-danger"></small>
                </div>
                <!-- bobot tugas -->
                <div class="form-group">
                    <label>Bobot Tugas</label>
                    <input type="text" name="tugas_bobot" id="tugas_bobot" class="form-control" required>
                    <small id="error-tugas_bobot" class="error-text form-text text-danger"></small>
                </div>

                <!-- Kuota -->
                <div class="form-group">
                    <label>Kuota</label>
                    <input type="text" name="kuota" id="kuota" class="form-control" required>
                    <small id="error-kuota" class="error-text form-text text-danger"></small>
                </div>

                <!-- tenggat -->
                <div class="form-group">
                    <label>Tenggat</label>
                    <input type="date" name="tugas_tenggat" id="tugas_tenggat" class="form-control" required>
                    <small id="error-tugas_tenggat" class="error-text form-text text-danger"></small>
                </div>

                <!-- periode -->
                <div class="form-group">
                    <label>Periode</label>
                    <select name="periode_id" id="periode_id" class="form-control" required>
                        <option value="" selected>--Select--</option>
                        
                        <@foreach ($periode as $periode): ?>
                        <option value="
                            <?= $periode['periode_id']; ?>">
                            <?= $periode['periode_tahun']; ?>
                        </option>
                        <@endforeach; ?>
                        
                    </select>
                    <small id="error-periode_id" class="error-text form-text text-danger"></small>
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
                jenis_id: {
                    required: true,
                    number:true
                },
                tugas_nama: {
                    required: true,
                    minlength: 3,
                    maxlength: 30
                },
                deskripsi: {
                    required: true,
                    minlength: 5,
                    maxlength: 255
                },
                tugas_bobot: {
                    required: true,
                    minlength: 1,
                    maxlength: 3
                },
                kuota: {
                    required: true,
                    minlength: 1,
                    maxlength: 2
                },
                tugas_tenggat: {
                    required: true,
                    minlength: 5,
                    maxlength: 20
                },
                periode_id: {
                    required: true
                }
            },
            submitHandler: function(form) {
                var formData = new FormData(form); // Menggunakan FormData untuk mengirim file

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    contentType: false, // Jaga agar tidak mengatur konten tipe
                    processData: false, // Jangan proses data
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            tableTugas.ajax.reload();
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