<form action="{{ url('/mhs/ajax/store') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Kompen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Mahasiswa</label>
                    <select name="mahasiswa_id" id="mahasiswa_id" class="form-control" required>
                        <option value="">- Pilih Mahasiswa -</option>
                        @foreach ($mahasiswa as $m)
                            <option value="{{ $m->mahasiswa_id }}">{{ $m->mahasiswa_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-mahasiswa_id" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Sakit</label>
                    <input type="number" name="sakit" id="sakit" class="form-control" required min="0" value="0">
                    <small id="error-sakit" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Izin</label>
                    <input type="number" name="izin" id="izin" class="form-control" required min="0" value="0">
                    <small id="error-izin" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Alpha</label>
                    <input type="number" name="alpha" id="alpha" class="form-control" required min="0" value="0">
                    <small id="error-alpha" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Poin</label>
                    <input type="number" name="poin" id="poin" class="form-control" required min="0" value="0">
                    <small id="error-poin" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <input type="text" name="status" id="status" class="form-control" required>
                    <small id="error-status" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Periode</label>
                    <input type="text" name="periode" id="periode" class="form-control" required minlength="4">
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
        $("#form-tambah").validate({
            rules: {
                mahasiswa_id: {
                    required: true,
                    number: true
                },
                sakit: {
                    required: true,
                    number: true,
                    min: 0
                },
                izin: {
                    required: true,
                    number: true,
                    min: 0
                },
                alpha: {
                    required: true,
                    number: true,
                    min: 0
                },
                poin: {
                    required: true,
                    number: true,
                    min: 0
                },
                status: {
                    required: true,
                    minlength: 3
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
                            dataKompen.ajax.reload();
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