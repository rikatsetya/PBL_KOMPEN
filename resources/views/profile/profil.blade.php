@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Menampilkan foto profil dan detail pengguna -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Profil Pengguna</h3>
                </div>
                <div class="card-body text-center">
                    <!-- Menampilkan foto profil -->
                    <div class="text-center">
    <div class="profile-img-container rounded-circle overflow-hidden mx-auto mb-4"
        style="width: 100px; height: 100px;">
        <img src="{{ $user->avatar ? asset('images/profile' . $user->avatar) : asset('images/default.png') }}"
            alt="Foto Profil"
            class="img-fluid w-100 h-100"
            style="object-fit: cover;">
    </div>
</div>



                    <!-- Detail pengguna -->
                    @if($user->level_id === 5)
                    <h3 style="font-size: 24px; font-weight: bold;">{{ $user['mahasiswa']->mahasiswa_nama }}</h3>
                    <p class="card-text">Username: {{ $user['mahasiswa']->username }}</p>
                    <p class="card-text">NIM: {{ $user['mahasiswa']->nim }}</p>
                    <p class="card-text">No Telepon: {{ $user['mahasiswa']->no_telp }}</p>
                    <p class="card-text">Jurusan: {{ $user['mahasiswa']->jurusan }}</p>
                    <p class="card-text">Prodi: {{ $user['mahasiswa']->prodi }}</p>
                    <p class="card-text">Kelas: {{ $user['mahasiswa']->kelas }}</p>
                    @elseif($user->level_id === 3)
                    <h3 style="font-size: 24px; font-weight: bold;">{{ $user['tendik']->tendik_nama }}</h3>
                    <p class="card-text">Username: {{ $user['tendik']->username }}</p>
                    <p class="card-text">NIP: {{ $user['tendik']->no_induk }}</p>
                    @elseif($user->level_id === 2)
                    <h3 style="font-size: 24px; font-weight: bold;">{{ $user['dosen']->dosen_nama }}</h3>
                    <p class="card-text">Username: {{ $user['dosen']->username }}</p>
                    <p class="card-text">NIP: {{ $user['dosen']->nip }}</p>
                    @else
                    <h3 style="font-size: 24px; font-weight: bold;">{{ $user['admin']->admin_nama }}</h3>
                    <p class="card-text">Username: {{ $user['admin']->username }}</p>
                    <p class="card-text">NIP: {{ $user['admin']->no_induk }}</p>
                    @endif

                    <!-- Tombol untuk edit profil -->
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary mt-3">Edit Profil</a>

                    <!-- Tombol untuk ganti password -->
                    <!-- <a href="{{ route('password.change') }}" class="btn btn-warning">Ganti Password</a> -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection