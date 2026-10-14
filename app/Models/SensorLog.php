<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SensorLog extends Model {
    protected $table = 'sensor_logs';
    protected $primaryKey = 'id_sensorlog';
    protected $fillable = ['id_alat', 'suhu', 'amonia', 'status'];

    public function alat(): BelongsTo {
        return $this->belongsTo(Alat::class, 'id_alat', 'id_alat');
    }
}
