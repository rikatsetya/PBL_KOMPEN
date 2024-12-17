<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeriodeModel extends Model
{
    use HasFactory;

    protected $table = 't_periode';
    protected $primaryKey = 'periode_id';

    protected $fillable = ['periode_tahun','periode_semester','created_at', 'updated_at'];

    public function tugas():HasMany
    {
        return $this->hasMany(TugasModel::class, 'tugas_id', 'tugas_id');
    }
    public function absensi():HasMany
    {
        return $this->hasMany(AbsensiModel::class, 'absensi_id', 'absensi_id');
    }
}