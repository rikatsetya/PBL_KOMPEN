@empty($tugas)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/manage_tugas') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/manage_tugas/' . $tugas->tugas_id . '/update_ajax') }}" method="POST" id="formedit" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data tugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Jenis Tugas</label>
                        <select name="jenis_id" id="jenis_id" class="form-control" required>
                            <option value="">- Pilih Jenis -</option>
                            @foreach($jenis as $jenis) <!-- Corrected variable name to 'levels' -->
                                <option {{ ($tugas->jenis_id == $jenis->jenis_id) ? 'selected' : '' }} value="{{ $jenis->jenis_id }}">
                                    {{ $jenis->jenis_nama }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-tugas_id" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Nama Tugas</label>
                        <input value="{{ $tugas->tugas_nama }}" type="text" name="tugas_nama" id="tugas_nama" class="form-control" required>
                        <small id="error-tugas_nama" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <input value="{{ $tugas->deskripsi }}" type="text" name="deskripsi" id="deskripsi" class="form-control" required>
                        <small id="error-deskripsi" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Bobot Tugas</label>
                        <input value="{{ $tugas->tugas_bobot }}" type="text" name="tugas_bobot" id="tugas_bobot" class="form-control">
                        <small id="error-tugas_bobot" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Tenggat</label>
                        <input value="{{ $tugas->tugas_tenggat }}" type="date" name="tugas_tenggat" id="tugas_tenggat" class="form-control">
                        <small id="error-tugas_tenggat" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Periode</label>
                        <select name="periode" id="periode_id" class="form-control"
                            required> 
                            <option value="" selected>--Select--</option>
                            <option value="2024/2025">2024/2025</option>
                        </select>
                        <small id="error-periode" class="error-text form-text text-danger"></small>
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
            $("#formedit").validate({
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
                tugas_tenggat: {
                    required: true,
                    minlength: 5,
                    maxlength: 20
                },
                periode: {
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
                    return false; // Prevent default form submission
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