@empty($daftar_tugas)
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
                <a href="{{ url('/daftar_tugas') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form>
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Data Tugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">Jenis Tugas</th>
                            <td class="col-9">{{ $daftar_tugas->jenis->jenis_nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Pembuat</th>
                            <td class="col-9">{{ $daftar_tugas->user->nama }} ({{ $daftar_tugas->user->level->level_nama }})</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nama Tugas</th>
                            <td class="col-9">{{ $daftar_tugas->tugas_nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Deskripsi Tugas</th>
                            <td class="col-9">{{ $daftar_tugas->deskripsi }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Bobot Poin Kompen</th>
                            <td class="col-9">{{ $daftar_tugas->tugas_bobot }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Tenggat Pengerjaan</th>
                            <td class="col-9">{{ $daftar_tugas->tugas_tenggat }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Periode Tugas</th>
                            <td class="col-9">{{ $daftar_tugas->periode->periode_tahun }} - {{ $daftar_tugas->periode->periode_semester }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Kuota Pekerja</th>
                            <td class="col-9">{{ $daftar_tugas->kuota }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Kembali</button>
                </div>
            </div>
        </div>
    </form>
@endempty