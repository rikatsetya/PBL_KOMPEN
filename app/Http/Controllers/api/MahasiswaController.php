<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\MahasiswaModel;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mahasiswa = MahasiswaModel::select(
            'username', 'mahasiswa_nama','nim','jurusan','prodi','kelas','no_telp'
        )->find($id);
        return $mahasiswa;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $data = MahasiswaModel::select('mahasiswa_id','mahasiswa_nama','username','no_telp')->where('mahasiswa_id', $request->mahasiswa_id)->first();
        $data->mahasiswa_nama = $request->mahasiswa_nama;
        $data->username = $request->username;
        $data->no_telp = $request->no_telp;
        $data->save();
        return "Berhasil Mengubah Data";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = MahasiswaModel::select('password')->where('mahasiswa_id', $request->mahasiswa_id)->first();
        $data->password = $request->password;
        $data->save();
        return "Berhasil Mengubah Data";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
