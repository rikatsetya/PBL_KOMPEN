<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TugasModel extends Model
{
    use HasFactory;
    protected $table = 't_tugas';
    protected $primaryKey = 'tugas_id';

    protected $fillable = ['jenis_id','user_id','tugas_nama','deskripsi','tugas_bobot','tugas_tenggat','periode_id', 'kuota','created_at', 'updated_at'];

    public function user():BelongsTo{
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }
    public function jenis():BelongsTo{
        return $this->belongsTo(JenisModel::class, 'jenis_id', 'jenis_id');
    }

    public function pengumpulan():HasMany{
        return $this->hasMany(PengumpulanModel::class, 'tugas_id', 'tugas_id');
    }
    
    public function periode():BelongsTo{
        return $this->belongsTo(PeriodeModel::class, 'periode_id', 'periode_id');
    }

}
