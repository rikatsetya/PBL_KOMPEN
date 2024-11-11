@empty($mahasiswa)
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
                <a href="{{ url('/mahasiswa') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form>
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Data mahasiswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">ID</th>
                            <td class="col-9">{{ $mahasiswa->mahasiswa_id }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">nim</th>
                            <td class="col-9">{{ $mahasiswa->nim }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Username</th>
                            <td class="col-9">{{ $mahasiswa->username }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nama mahasiswa</th>
                            <td class="col-9">{{ $mahasiswa->mahasiswa_nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">No Telp.</th>
                            <td class="col-9">{{ $mahasiswa->no_telp }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Jurusan</th>
                            <td class="col-9">{{ $mahasiswa->jurusan }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Prodi</th>
                            <td class="col-9">{{ $mahasiswa->prodi }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Kelas</th>
                            <td class="col-9">{{ $mahasiswa->kelas }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Password</th>
                            <td class="col-9">********</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">foto</th>
                            <td class="col-9"><img src=" {{ asset($mahasiswa->foto) }} " height="100" alt="Foto Kosong"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                </div>
            </div>
        </div>
    </form>
@endempty

