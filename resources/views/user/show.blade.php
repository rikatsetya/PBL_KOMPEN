@empty($user)
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
                <a href="{{ url('/user') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form>
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Data User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm table-bordered table-striped">
                        @switch($user->level_id)
                            @case('1')
                            <tr>
                                <th class="text-right col-3">Level</th>
                                <td class="col-9">{{ $user->level_nama }}</td>
                            </tr>
                            <tr>
                                <th class="text-right col-3">Username</th>
                                <td class="col-9">{{ $user->username }}</td>
                            </tr>
                            <tr>
                                <th class="text-right col-3">Nama</th>
                                <td class="col-9">{{ $user->admin_nama }}</td>
                            </tr>
                            <tr>
                                <th class="text-right col-3">Nomer Induk</th>
                                <td class="col-9">{{ $user->no_induk }}</td>
                            </tr>
                            <tr>
                                <th class="text-right col-3">Password</th>
                                <td class="col-9">********</td>
                            </tr>
                            <tr>
                                <th class="text-right col-3">foto</th>
                                <td class="col-9"><img src=" {{ asset($user->foto) }} " height="100" alt="Foto Kosong">
                                </td>
                            </tr>
                                @break
                            @case('2')
                            <tr>
                                <th class="text-right col-3">Level</th>
                                <td class="col-9">{{ $user->level_nama }}</td>
                            </tr>
                            <tr>
                                <th class="text-right col-3">Username</th>
                                <td class="col-9">{{ $user->username }}</td>
                            </tr>
                            <tr>
                                <th class="text-right col-3">Nama</th>
                                <td class="col-9">{{ $user->dosen_nama }}</td>
                            </tr>
                            <tr>
                                <th class="text-right col-3">NIP</th>
                                <td class="col-9">{{ $user->nip }}</td>
                            </tr>
                            <tr>
                                <th class="text-right col-3">Password</th>
                                <td class="col-9">********</td>
                            </tr>
                            <tr>
                                <th class="text-right col-3">foto</th>
                                <td class="col-9"><img src=" {{ asset($user->foto) }} " height="100" alt="Foto Kosong">
                                </td>
                            </tr>
                                @break
                            @case('3')
                            <tr>
                                <th class="text-right col-3">Level</th>
                                <td class="col-9">{{ $user->level_nama }}</td>
                            </tr>
                            <tr>
                                <th class="text-right col-3">Username</th>
                                <td class="col-9">{{ $user->username }}</td>
                            </tr>
                            <tr>
                                <th class="text-right col-3">Nama</th>
                                <td class="col-9">{{ $user->tendik_nama }}</td>
                            </tr>
                            <tr>
                                <th class="text-right col-3">Nomer Induk</th>
                                <td class="col-9">{{ $user->no_induk }}</td>
                            </tr>
                            <tr>
                                <th class="text-right col-3">Password</th>
                                <td class="col-9">********</td>
                            </tr>
                            <tr>
                                <th class="text-right col-3">foto</th>
                                <td class="col-9"><img src=" {{ asset($user->foto) }} " height="100" alt="Foto Kosong">
                                </td>
                            </tr>
                                @break
                        
                            @default
                                
                        @endswitch
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                </div>
            </div>
        </div>
    </form>
@endempty
