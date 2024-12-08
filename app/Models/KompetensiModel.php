<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KompetensiModel extends Model
{
    use HasFactory;

    protected $table = 't_kompetensi';
    protected $primaryKey = 'kompetensi_id';

    protected $fillable = ['kompetensi_nama','kompetensi_deskripsi','created_at', 'updated_at'];

    public function kompetensiMhs():HasMany
    {
        return $this->hasMany(KompetensiMhsModel::class);
    }
    public function kompetensiTugas():HasMany
    {
        return $this->hasMany(KompetensiTugasModel::class);
    }
}
