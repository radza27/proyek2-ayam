<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BatasAmbang extends Model {
    protected $table = 'batas_ambangs';
    protected $primaryKey = 'id_ambang';
    protected $fillable = ['id_alat', 'suhuMin', 'suhuMax', 'amoniaMax'];

    public function alat(): BelongsTo {
        return $this->belongsTo(Alat::class, 'id_alat', 'id_alat');
    }
}