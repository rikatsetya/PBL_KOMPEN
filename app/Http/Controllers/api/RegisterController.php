<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\MahasiswaModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        
        
        $validator = Validator::make($request->all(), [
            'username'  => 'required|string|min:3|unique:m_mahasiswa,username',
            'mahasiswa_nama'      => 'required|string|max:100',
            'nim'      => 'required|integer|unique:m_mahasiswa,nim',
            'no_telp'      => 'required|integer',
            'jurusan'      => 'required|string',
            'prodi'      => 'required|string',
            'kelas'      => 'required|string|max:2',
            'password'  => 'required|min:6'
        ]);
        $request['foto']='images/profile/default.jpg';
        // cek apakah request berupa ajax
        if ($validator->fails()) {
            return response()->json([
                'success'    => false, // response status, false: error/gagal, true: berhasil
                'message'   => 'Validasi Gagal',
                'msgField'  => $validator->errors(), // pesan error validasi
            ]);
        }
        
        $userId= UserModel::insertGetId([
            'level_id' => '5',
            'username' => $request->username,
            'nama' => $request->mahasiswa_nama,
            'password' => bcrypt($request->password),
        ]);
        $request['user_id']= $userId;
        if (!empty($request['user_id'])) {
            $data = MahasiswaModel::create($request->all());
        }
        if($data){
            return response()->json([
                'success' => true,
                'user' => $data,
            ], 200);
        }

        // return JSON process insert failed
        return response()->json([
            'success' => false,
        ], 409);

    }
}
