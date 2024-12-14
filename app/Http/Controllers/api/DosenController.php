<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\DosenModel;
use Illuminate\Http\Request;

class DosenController extends Controller
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
    public function show(Request $request)
    {
        $data = DosenModel::select(
            'user_id',
            'dosen_id',
            'nip',
            'username',
            'dosen_nama',
            'foto',
        )
            ->where('user_id', $request->id)
            ->first();

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $data = DosenModel::all()->where('dosen_id', $request->id)->first();
        $data->mahasiswa_nama = $request->mahasiswa_nama;
        $data->username = $request->username;
        $data->no_telp = $request->no_telp;
        $data->save();
        return "Berhasil Mengubah Data";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = DosenModel::all()->where('user_id', $request->id)->first();
        $data->password = bcrypt($request->password);
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