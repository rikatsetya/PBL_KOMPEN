<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdminModel extends Model
{
    use HasFactory;

    protected $table = 'm_admin';
    protected $primaryKey = 'admin_id';

    protected $fillable = ['no_induk','username','admin_nama','password','foto'];

    public function tugas(): HasMany{
        return $this->hasMany(TugasModel::class);
    }
    public function absensi(): HasMany{
        return $this->hasMany(AbsensiModel::class);
    }
    public function surat(): HasMany{
        return $this->hasMany(SuratModel::class);
    }
}
