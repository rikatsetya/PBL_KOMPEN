<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DosenModel extends Model
{
    use HasFactory;

    protected $table = 'm_dosen';
    protected $primaryKey = 'dosen_id';

    protected $fillable = ['nip','user_id','username','dosen_nama','password','foto'];
    protected $hiidden = ['password'];

    protected $casts = ['password' => 'hashed'];

    public function tugas(): HasMany{
        return $this->hasMany(TugasModel::class);
    }

    public function user(): BelongsTo{
        return $this->belongsTo(UserModel::class);
    }
}
