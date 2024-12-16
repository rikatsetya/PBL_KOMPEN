<<<<<<< HEAD
@empty($mhs)
=======
@empty($mahasiswa)
>>>>>>> 0916f1e641e08abb12c4e55b5e84393c72c4d7e5
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
<<<<<<< HEAD
                <a href="{{ url('/mhs') }}" class="btn btn-warning">Kembali</a>
=======
                <a href="{{ url('/mahasiswa') }}" class="btn btn-warning">Kembali</a>
>>>>>>> 0916f1e641e08abb12c4e55b5e84393c72c4d7e5
            </div>
        </div>
    </div>
@else
<<<<<<< HEAD
    <form action="{{ url('/mhs/' . $mhs->id . '/delete_ajax') }}" method="POST" id="form-delete">
=======
    <form action="{{ url('/mahasiswa/' . $mahasiswa->mahasiswa_id . '/delete_ajax') }}" method="POST" id="form-delete">
>>>>>>> 0916f1e641e08abb12c4e55b5e84393c72c4d7e5
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
<<<<<<< HEAD
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data Mahasiswa Kompen</h5>
=======
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data mahasiswa</h5>
>>>>>>> 0916f1e641e08abb12c4e55b5e84393c72c4d7e5
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-ban"></i> Konfirmasi !!!</h5>
<<<<<<< HEAD
                        Apakah Anda ingin menghapus data berikut?
                    </div>
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">Nama Mahasiswa:</th>
                            <td class="col-9">{{ $mhs->mahasiswa->mahasiswa_nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Sakit:</th>
                            <td class="col-9">{{ $mhs->sakit }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Izin:</th>
                            <td class="col-9">{{ $mhs->izin }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Alpha:</th>
                            <td class="col-9">{{ $mhs->alpha }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Poin:</th>
                            <td class="col-9">{{ $mhs->poin }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Status:</th>
                            <td class="col-9">{{ $mhs->status }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Periode:</th>
                            <td class="col-9">{{ $mhs->periode }}</td>
=======
                        Apakah Anda ingin menghapus data seperti di bawah ini?
                    </div>
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">Username :</th>
                            <td class="col-9">{{ $mahasiswa->username }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nama Mahasiswa :</th>
                            <td class="col-9">{{ $mahasiswa->mahasiswa_nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">NIM :</th>
                            <td class="col-9">{{ $mahasiswa->nim }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">No_telp :</th>
                            <td class="col-9">{{ $mahasiswa->no_telp }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Jurusan :</th>
                            <td class="col-9">{{ $mahasiswa->jurusan }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Prodi :</th>
                            <td class="col-9">{{ $mahasiswa->prodi }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Kelas :</th>
                            <td class="col-9">{{ $mahasiswa->mahasiswa_nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Password :</th>
                            <td class="col-9">***********</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">foto</th>
                            <td class="col-9"><img src=" {{ asset($mahasiswa->foto) }} " height="100" alt="Foto Kosong"></td>
>>>>>>> 0916f1e641e08abb12c4e55b5e84393c72c4d7e5
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
<<<<<<< HEAD
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
=======
                    <button type="submit" class="btn btn-primary">Ya, Hapus</button>
>>>>>>> 0916f1e641e08abb12c4e55b5e84393c72c4d7e5
                </div>
            </div>
        </div>
    </form>
<<<<<<< HEAD

=======
>>>>>>> 0916f1e641e08abb12c4e55b5e84393c72c4d7e5
    <script>
        $(document).ready(function() {
            $("#form-delete").validate({
                rules: {},
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
<<<<<<< HEAD
                                dataMahasiswaKompen.ajax.reload(); // Reload table if needed
                            } else {
=======
                                tableMahasiswa.ajax.reload();
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
>>>>>>> 0916f1e641e08abb12c4e55b5e84393c72c4d7e5
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