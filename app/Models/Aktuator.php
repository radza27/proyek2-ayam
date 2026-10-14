<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Aktuator extends Model {
    protected $table = 'aktuators';
    protected $primaryKey = 'id_aktuator';
    protected $fillable = ['id_alat', 'nama', 'relay_code', 'otomatisasi', 'status', 'keterangan'];

    public function alat(): BelongsTo {
        return $this->belongsTo(Alat::class, 'id_alat', 'id_alat');
    }
}
