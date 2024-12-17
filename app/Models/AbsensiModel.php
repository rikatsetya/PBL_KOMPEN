<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AbsensiModel extends Model
{
    use HasFactory;

    protected $table = 't_absensi_mhs';
    protected $primaryKey = 'absensi_id';

    protected $fillable = ['mahasiswa_id','alpha','poin','status','periode_id','created_at', 'updated_at'];

    public function mahasiswa(): BelongsTo{
        return $this->belongsTo(MahasiswaModel::class, 'mahasiswa_id', 'mahasiswa_id');
    }
    public function user(): BelongsTo{
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }
    public function surat(): HasOne{
        return $this->hasOne(SuratModel::class, 'surat_id', 'surat_id');
    }
    public function periode(): BelongsTo{
        return $this->belongsTo(PeriodeModel::class, 'periode_id', 'periode_id');
    }
}
