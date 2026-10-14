<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Alat;
use App\Models\SensorLog;
use App\Models\Aktuator;
use App\Models\BatasAmbang;
use Illuminate\Support\Facades\Hash;

class PrimaFarmSeeder extends Seeder {
    public function run(): void {
        // 1. Buat User Dummy
        $user = User::create([
            'nama' => 'Admin Prima Farm',
            'username' => 'admin',
            'email' => 'admin@primafarm.id',
            'password' => Hash::make('password123')
        ]);

        // 2. Buat Alat / Node IoT
        $alat = Alat::create([
            'id_akun' => $user->id_akun,
            'nama' => 'ESP32 Biosecurity A',
            'lokasi' => 'Kandang Utama Blora',
            'status' => true
        ]);

        // 3. Buat Batas Ambang (Sesuai Mockup Pengaturan)
        BatasAmbang::create([
            'id_alat' => $alat->id_alat,
            'suhuMin' => 24,
            'suhuMax' => 32,
            'amoniaMax' => 20
        ]);

        // 4. Buat Aktuator (Sesuai Mockup Kendali Aktuator)
        Aktuator::create(['id_alat' => $alat->id_alat, 'nama' => 'Kipas Exhaust', 'relay_code' => 'RELAY #01', 'otomatisasi' => true, 'status' => true, 'keterangan' => 'Pendingin kandang']);
        Aktuator::create(['id_alat' => $alat->id_alat, 'nama' => 'Lampu Pemanas', 'relay_code' => 'RELAY #02', 'otomatisasi' => true, 'status' => false, 'keterangan' => 'Pemanas kandang']);
        Aktuator::create(['id_alat' => $alat->id_alat, 'nama' => 'Atap Otomatis', 'relay_code' => 'RELAY #03', 'otomatisasi' => true, 'status' => true, 'keterangan' => 'Ventilasi tambahan']);

        // 5. Buat Riwayat Sensor Log (Sesuai Mockup Tabel Riwayat & Dashboard)
        $waktuSekarang = now();
        for ($i = 0; $i < 10; $i++) {
            SensorLog::create([
                'id_alat' => $alat->id_alat,
                'suhu' => round(27.0 + (rand(0, 20) / 10), 1),
                'amonia' => round(13.0 + (rand(0, 30) / 10), 1),
                'status' => 'Aman',
                'created_at' => (clone $waktuSekarang)->subMinutes($i * 15)
            ]);
        }
    }
}