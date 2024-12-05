<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaModel extends Model
{
    use HasFactory;

    protected $table = 'm_mahasiswa';

    protected $primaryKey = 'mahasiswa_id';

    protected $fillable = [
        'nim',
        'username',
        'mahasiswa_nama',
        'password',
        'foto',
        'no_telp',
        'jurusan',
        'prodi',
        'kelas',
        'created_at',
        'updated_at',
    ];

    // Relasi ke model AbsensiMahasiswa
    public function absensi()
    {
        return $this->hasMany(AbsensiMahasiswaModel::class, 'mahasiswa_id', 'mahasiswa_id');
    }
}
