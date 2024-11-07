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

    protected $fillable = ['dosen_id','tendik_id','admin_id','tugas_nama','deskripsi','tugas_bobot','tugas_tenggat','periode'];

    public function dosen():BelongsTo{
        return $this->belongsTo(DosenModel::class);
    }
    public function tendik():BelongsTo{
        return $this->belongsTo(TendikModel::class);
    }
    public function admin():BelongsTo{
        return $this->belongsTo(AdminModel::class);
    }
    public function pengumpulan():HasMany{
        return $this->hasMany(PengumpulanModel::class);
    }
}