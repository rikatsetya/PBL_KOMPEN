<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasModel extends Model
{
    use HasFactory;
    protected $table = 'm_tugas';
    protected $primaryKey = 'tugas_id';

    protected $fillable = ['tugas_nama', 'deskripsi'];

    public function pengumpulanTugas()
    {
        return $this->hasMany(PengumpulanModel::class, 'tugas_id', 'tugas_id');
    }
}
