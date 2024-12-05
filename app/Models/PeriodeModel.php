<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodeModel extends Model
{
    use HasFactory;

    protected $table = 't_periode';

    protected $primaryKey = 'periode_id';

    protected $fillable = [
        'periode_tahun',
        'created_at',
        'updated_at',
    ];

    // Relasi ke model AbsensiMahasiswa
    public function absensi()
    {
        return $this->hasMany(AbsensiMahasiswaModel::class, 'periode_id', 'periode_id');
    }
}
