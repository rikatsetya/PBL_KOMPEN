<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiMahasiswaModel extends Model
{
    use HasFactory;

    protected $table = 't_absensi_mhs';

    protected $primaryKey = 'absensi_id';

    protected $fillable = [
        'mahasiswa_id',
        'periode_id',
        'alpha',
        'poin',
        'status',
        'created_at',
        'updated_at',
    ];

    // Relasi ke model Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class, 'mahasiswa_id', 'mahasiswa_id');
    }

    // Relasi ke model Periode
    public function periode()
    {
        return $this->belongsTo(PeriodeModel::class, 'periode_id', 'periode_id');
    }
}
