<?php

namespace App\Http\Controllers;

use App\Models\TugasModel;
use Illuminate\Http\Request;

class TugasControllerMbl extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = TugasModel::select(
            'm_user.user_id',

            'nama',
            't_tugas.tugas_id',
            't_tugas.user_id',
            't_tugas.tugas_nama',
            't_tugas.deskripsi',
            't_tugas.tugas_bobot',
            't_tugas.tugas_tenggat',
            't_tugas.periode',
        )
            ->rightJoin('m_user', 't_tugas.user_id', '=', 'm_user.user_id')
            ->get();

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
        // Validasi input
        $validatedData = $request->validate([
            'user_id' => 'required|integer|exists:m_user,user_id',
            'tugas_nama' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'tugas_bobot' => 'required|integer',
            'tugas_tenggat' => 'required|date',
            'periode' => 'required|string',
        ]);

        try {
            // Buat data baru
            $tugas = TugasModel::create([
                'user_id' => $validatedData['user_id'],
                'tugas_nama' => $validatedData['tugas_nama'],
                'deskripsi' => $validatedData['deskripsi'], // Jika null, berikan nilai kosong
                'tugas_bobot' => $validatedData['tugas_bobot'],
                'tugas_tenggat' => $validatedData['tugas_tenggat'],
                'periode' => $validatedData['periode'],
            ]);

            // Berikan respon sukses
            return response()->json([
                'message' => 'Tugas berhasil ditambahkan',
                'data' => $tugas,
            ], 201);
        } catch (\Exception $e) {
            // Tangani error jika ada kesalahan
            return response()->json([
                'message' => 'Terjadi kesalahan saat menambahkan tugas',
                'error' => $e->getMessage(),
            ], 500);
        }
        // $data = TugasModel::all();
        // $data->create($request->all());
        // return $data;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
