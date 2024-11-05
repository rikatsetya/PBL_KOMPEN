<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengumpulanModel extends Model
{
    use HasFactory;
    protected $table = 't_pengumpulan';
    protected $primaryKey = 'pengumpulan_id';

    protected $fillable = ['tugas_id','mahasiswa_id','lampiran','foto_sebelum','foto_sesudah','tanggal'];

    public function mahasiswa():BelongsTo{
        return $this->belongsTo(MahasiswaModel::class);
    }
    public function tugas():BelongsTo{
        return $this->belongsTo(TugasModel::class);
    }

}
