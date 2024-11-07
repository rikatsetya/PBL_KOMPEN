<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengumpulanModel;

class PengumpulanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = PengumpulanModel::all();
        return response()->json($data);
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
        $request->validate([
            'tugas_id' => 'required|integer',
            'mahasiswa_id' => 'required|integer',
            'lampiran' => 'required|string',
            'foto_sebelum' => 'nullable|string',
            'foto_sesudah' => 'nullable|string',
            'tanggal' => 'required|date',
        ]);

        $save = new PengumpulanModel;
        $save->tugas_id = $request->tugas_id;
        $save->mahasiswa_id = $request->mahasiswa_id;
        $save->lampiran = $request->lampiran;
        $save->foto_sebelum = $request->foto_sebelum;
        $save->foto_sesudah = $request->foto_sesudah;
        $save->tanggal = $request->tanggal;
        $save->save();

        return response()->json(['message' => 'Berhasil Menyimpan Data'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = PengumpulanModel::where('pengumpulan_id', $id)->first();
        if ($data) {
            return response()->json($data);
        }

        return response()->json(['message' => 'Data tidak ditemukan'], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $data = PengumpulanModel::where('pengumpulan_id', $id)->first();
        if ($data) {
            $data->tugas_id = $request->tugas_id;
            $data->mahasiswa_id = $request->mahasiswa_id;
            $data->lampiran = $request->lampiran;
            $data->foto_sebelum = $request->foto_sebelum;
            $data->foto_sesudah = $request->foto_sesudah;
            $data->tanggal = $request->tanggal;
            $data->save();

            return response()->json(['message' => 'Berhasil Mengubah Data'], 200);
        }

        return response()->json(['message' => 'Data tidak ditemukan'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = PengumpulanModel::where('pengumpulan_id', $id)->first();
        if ($data) {
            $data->tugas_id = $request->tugas_id;
            $data->mahasiswa_id = $request->mahasiswa_id;
            $data->lampiran = $request->lampiran;
            $data->foto_sebelum = $request->foto_sebelum;
            $data->foto_sesudah = $request->foto_sesudah;
            $data->tanggal = $request->tanggal;
            $data->save();

            return response()->json(['message' => 'Berhasil Memperbarui Data'], 200);
        }

        return response()->json(['message' => 'Data tidak ditemukan'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $del = PengumpulanModel::where('pengumpulan_id', $id)->first();
        if ($del) {
            $del->delete();
            return response()->json(['message' => 'Berhasil Menghapus Data'], 200);
        }

        return response()->json(['message' => 'Data tidak ditemukan'], 404);
    }
}
