@empty($tugas)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria label="Close"><span
                        aria-hidden="true">&times;</span></button>
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
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data Tugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th class="text-center col-2">ID</th>
                        <td class="col-9">{{ $tugas->tugas_id }}</td>
                    </tr>
                    <tr>
                        <th class="text-center col-2">Jenis Tugas</th>
                        <td class="col-9">{{ $tugas->jenis->jenis_nama }}</td>
                    </tr>
                    <tr>
                        <th class="text-center col-2">Pembuat Tugas</th>
                        <td class="col-9">{{ $tugas->user->nama }} ({{ $tugas->user->level->level_nama }})</td>
                    </tr>
                    <tr>
                        <th class="text-center col-2">Nama Tugas</th>
                        <td class="col-9">{{ $tugas->tugas_nama }}</td>
                    </tr>
                    <tr>
                        <th class="text-center col-2">Deskripsi Tugas</th>
                        <td class="col-9">{{ $tugas->deskripsi }}</td>
                    </tr>
                    <tr>
                        <th class="text-center col-2">Bobot Tugas</th>
                        <td class="col-9">{{ $tugas->tugas_bobot }}</td>
                    </tr>
                    <tr>
                        <th class="text-center col-2">Kuota</th>
                        <td class="col-9">{{ $tugas->kuota }}</td>
                    </tr>
                    <tr>
                        <th class="text-center col-2">Tenggat Tugas</th>
                        <td class="col-9">{{ $tugas->tugas_tenggat }}</td>
                    </tr>
                    <tr>
                        <th class="text-center col-2">Periode Tugas</th>
                        <td class="col-9">{{ $tugas->periode->periode_tahun }} {{$tugas->periode->periode_semester}}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Kembali</button>
            </div>
        </div>
    </div>
@endempty