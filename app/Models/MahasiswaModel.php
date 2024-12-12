<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MahasiswaModel extends Model
{
    use HasFactory;

    protected $table = 'm_mahasiswa';
    protected $primaryKey = 'mahasiswa_id';

    protected $fillable = ['user_id','nim','username','mahasiswa_nama','password','foto','no_telp','jurusan','prodi','kelas','created_at', 'updated_at'];

    protected $hiidden = ['password'];

    protected $casts = ['password' => 'hashed'];

    public function pengumpulan(): HasMany{
        return $this->hasMany(TugasModel::class, 'pengumpulan_id', 'pengumpulan_id');
    }
    public function absensi(): HasOne{
        return $this->hasOne(AbsensiModel::class, 'absensi_id', 'absensi_id');
    }
    public function user(): BelongsTo{
        return $this->belongsTo(UserModel::class);
    }
}

