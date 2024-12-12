<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisModel extends Model
{
    use HasFactory;
    protected $table = 't_jenis_tugas';
    protected $primaryKey = 'jenis_id';

    protected $fillable = ['jenis_nama','created_at', 'updated_at'];

    public function tugas():HasMany
    {
        return $this->hasMany(TugasModel::class, 'tugas_id', 'tugas_id');
    }
}
