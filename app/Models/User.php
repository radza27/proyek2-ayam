<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Import Authenticatable
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    
    // Wajib didefinisikan karena primary key tabel kita adalah id_akun (bukan 'id')
    protected $primaryKey = 'id_akun';

    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function alats(): HasMany
    {
        return $this->hasMany(Alat::class, 'id_akun', 'id_akun');
    }
}