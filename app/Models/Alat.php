<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Alat extends Model {
    protected $table = 'alats';
    protected $primaryKey = 'id_alat';
    protected $fillable = ['id_akun', 'nama', 'lokasi', 'status'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'id_akun', 'id_akun');
    }

    public function sensorLogs(): HasMany {
        return $this->hasMany(SensorLog::class, 'id_alat', 'id_alat');
    }

    public function aktuators(): HasMany {
        return $this->hasMany(Aktuator::class, 'id_alat', 'id_alat');
    }

    public function batasAmbang(): HasOne {
        return $this->hasOne(BatasAmbang::class, 'id_alat', 'id_alat');
    }
}