<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MahasiswaKompenModel extends Model
{
    use HasFactory;

    protected $table = 't_absensi_mhs';
    protected $primaryKey = 'absensi_id';

    protected $fillable = ['mahasiswa_id', 'sakit', 'izin', 'alpha', 'poin', 'status', 'periode'];

    public function mahasiswa():BelongsTo
    {
        return $this->belongsTo(MahasiswaModel::class, 'mahasiswa_id','mahasiswa_id');
    }
}
