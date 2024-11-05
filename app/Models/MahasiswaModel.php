<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MahasiswaModel extends Model
{
    use HasFactory;

    protected $table = 'm_mahasiswa';
    protected $primaryKey = 'mahasiswa_id';

    protected $fillable = ['nim','username','mahasiswa_nama','password','foto','no_telp','jurusan','prodi','kelas'];

    public function pengumpulan(): HasMany{
        return $this->hasMany(TugasModel::class);
    }
    public function absensi(): HasOne{
        return $this->hasOne(AbsensiModel::class);
    }
}

