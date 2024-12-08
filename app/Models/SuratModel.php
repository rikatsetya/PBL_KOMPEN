<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratModel extends Model
{
    use HasFactory;
    protected $table = 't_surat_kompen';
    protected $primaryKey = 'surat_id';

    protected $fillable = ['mahasiswa_id','admin_id','absensi_id','tanggal_pengajuan','created_at', 'updated_at'];

    public function mahasiswa(): BelongsTo{
        return $this->belongsTo(MahasiswaModel::class);
    }
    public function admin(): BelongsTo{
        return $this->belongsTo(AdminModel::class);
    }
    public function absensi(): BelongsTo{
        return $this->belongsTo(AdminModel::class);
    }
}
