<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AbsensiModel extends Model
{
    use HasFactory;

    protected $table = 'm_absensi_mhs';
    protected $primaryKey = 'absensi_id';

    protected $fillable = ['mahasiswa_id','sakit','izin','alpha','poin','status','periode'];

    public function mahasiswa(): BelongsTo{
        return $this->belongsTo(MahasiswaModel::class);
    }
    public function admin(): BelongsTo{
        return $this->belongsTo(AdminModel::class);
    }
    public function surat(): HasOne{
        return $this->hasOne(SuratModel::class);
    }
}
