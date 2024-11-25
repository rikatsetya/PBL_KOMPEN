@empty($mhs)
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
                    <a href="{{ url('/mhs') }}" class="btn btn-warning">Kembali</a>
                </div>
            </div>
        </div>
    @else
        <form action="{{ url('/mhs/' . $mhs->absensi_id . '/update_ajax') }}" method="POST" id="form-edit">
            @csrf
            @method('PUT')
            <div id="modal-master" class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Data Kompensasi Mahasiswa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Mahasiswa</label>
                            <select name="mahasiswa_id" id="mahasiswa_id" class="form-control" required>
                                <option value="">- Pilih Mahasiswa -</option>
                                @foreach ($level as $l)
                                    <option value="{{ $l->mahasiswa_id }}" 
                                        {{ $l->mahasiswa_id == $mhs->mahasiswa_id ? 'selected' : '' }}>
                                        {{ $l->mahasiswa_nama }}
                                    </option>
                                @endforeach
                            </select>
                            <small id="error-mahasiswa_id" class="error-text form-text text-danger"></small>
                        </div>

                        <div class="form-group">
                            <label>Sakit</label>
                            <input type="number" name="sakit" id="sakit" value="{{ $mhs->sakit }}" class="form-control" required min="0">
                            <small id="error-sakit" class="error-text form-text text-danger"></small>
                        </div>

                        <div class="form-group">
                            <label>Izin</label>
                            <input type="number" name="izin" id="izin" value="{{ $mhs->izin }}" class="form-control" required min="0">
                            <small id="error-izin" class="error-text form-text text-danger"></small>
                        </div>

                        <div class="form-group">
                            <label>Alpha</label>
                            <input type="number" name="alpha" id="alpha" value="{{ $mhs->alpha }}" class="form-control" required min="0">
                            <small id="error-alpha" class="error-text form-text text-danger"></small>
                        </div>

                        <div class="form-group">
                            <label>Poin</label>
                            <input type="number" name="poin" id="poin" value="{{ $mhs->poin }}" class="form-control" required min="0">
                            <small id="error-poin" class="error-text form-text text-danger"></small>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="Aktif" {{ $mhs->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Tidak Aktif" {{ $mhs->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            <small id="error-status" class="error-text form-text text-danger"></small>
                        </div>

                        <div class="form-group">
                            <label>Periode</label>
                            <input type="text" name="periode" id="periode" value="{{ $mhs->periode }}" class="form-control" required minlength="4">
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
                $("#form-edit").validate({
                    rules: {
                        mahasiswa_id: {
                            required: true,
                            number: true
                        },
                        sakit: {
                            required: true,
                            min: 0
                        },
                        izin: {
                            required: true,
                            min: 0
                        },
                        alpha: {
                            required: true,
                            min: 0
                        },
                        poin: {
                            required: true,
                            min: 0
                        },
                        status: {
                            required: true
                        },
                        periode: {
                            required: true,
                            minlength: 4
                        }
                    },
                    submitHandler: function(form) {
                        $.ajax({
                            url: form.action,
                            type: form.method,
                            data: $(form).serialize(),
                            success: function(response) {
                                if (response.status) {
                                    $('#myModal').modal('hide');
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.message
                                    });
                                    dataMahasiswa.ajax.reload();
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
    @endempty