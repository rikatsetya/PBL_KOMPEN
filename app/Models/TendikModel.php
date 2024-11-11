<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TendikModel extends Model
{
    use HasFactory;

    protected $table = 'm_tendik';
    protected $primaryKey = 'tendik_id';

    protected $fillable = ['no_induk','username','tendik_nama','password','foto','created_at', 'updated_at'];

    public function tugas(): HasMany{
        return $this->hasMany(TugasModel::class);
    }
}
