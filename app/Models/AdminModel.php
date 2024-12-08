<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdminModel extends Model
{
    use HasFactory;

    protected $table = 'm_admin';
    protected $primaryKey = 'admin_id';

    protected $fillable = ['no_induk', 'user_id','username','admin_nama','password','foto'];
    protected $hiidden = ['password'];

    protected $casts = ['password' => 'hashed'];

    public function tugas(): HasMany{
        return $this->hasMany(TugasModel::class);
    }
    public function absensi(): HasMany{
        return $this->hasMany(AbsensiModel::class);
    }
    public function surat(): HasMany{
        return $this->hasMany(SuratModel::class);
    }
    public function user(): BelongsTo{
        return $this->belongsTo(UserModel::class);
    }
}
