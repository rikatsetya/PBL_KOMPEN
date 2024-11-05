<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DosenModel extends Model
{
    use HasFactory;

    protected $table = 'm_dosen';
    protected $primaryKey = 'dosen_id';

    protected $fillable = ['nip','username','dosen_nama','password','foto'];

    public function tugas(): HasMany{
        return $this->hasMany(TugasModel::class);
    }
}
