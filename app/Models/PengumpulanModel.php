<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengumpulanModel extends Model
{
    use HasFactory;
    protected $table = 't_pengumpulan_tugas';
    protected $primaryKey = 'pengumpulan_id';

    protected $fillable = ['tugas_id','mahasiswa_id','lampiran','foto_sebelum','foto_sesudah','tanggal','status', 'alasan','created_at', 'updated_at'];

    public function mahasiswa():BelongsTo{
        return $this->belongsTo(MahasiswaModel::class, 'mahasiswa_id', 'mahasiswa_id');
    }
    public function tugas():BelongsTo{
        return $this->belongsTo(TugasModel::class, 'tugas_id', 'tugas_id');
    }

}
