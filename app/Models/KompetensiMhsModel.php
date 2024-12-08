<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KompetensiMhsModel extends Model
{
    use HasFactory;
    protected $table = 't_kompetensi_mahasiswa';
    protected $fillable = ['mahasiswa_id','kompetensi_id','created_at', 'updated_at'];

    public function kompetensi():BelongsTo
    {
        return $this->belongsTo(KompetensiModel::class, 'kompetensi_id','kompetensi_id');
    }
    public function mahasiswa():BelongsTo
    {
        return $this->belongsTo(MahasiswaModel::class,'mahasiswa_id', 'mahasiswa_id');
    }
}
