<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TendikModel extends Model
{
    use HasFactory;

    protected $table = 'm_tendik';
    protected $primaryKey = 'tendik_id';

    protected $fillable = ['user_id','no_induk','username','tendik_nama','password','foto','created_at', 'updated_at'];
    protected $hiidden = ['password'];

    protected $casts = ['password' => 'hashed'];

    public function tugas(): HasMany{
        return $this->hasMany(TugasModel::class);
    }
    public function user(): BelongsTo{
        return $this->belongsTo(UserModel::class);
    }
}
