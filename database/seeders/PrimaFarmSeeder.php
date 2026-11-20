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
        $ambang = BatasAmbang::create([
            'id_alat' => $alat->id_alat,
            'suhuMin' => 24,
            'suhuMax' => 32,
            'amoniaMax' => 20
        ]);

        // 4. Buat Aktuator (Sesuai Mockup Kendali Aktuator)
        Aktuator::create(['id_alat' => $alat->id_alat, 'nama' => 'Kipas Exhaust', 'relay_code' => 'RELAY #01', 'otomatisasi' => true, 'status' => true, 'keterangan' => 'Pendingin kandang']);
        Aktuator::create(['id_alat' => $alat->id_alat, 'nama' => 'Lampu Pemanas', 'relay_code' => 'RELAY #02', 'otomatisasi' => true, 'status' => false, 'keterangan' => 'Pemanas kandang']);
        Aktuator::create(['id_alat' => $alat->id_alat, 'nama' => 'Atap Otomatis', 'relay_code' => 'RELAY #03', 'otomatisasi' => true, 'status' => true, 'keterangan' => 'Ventilasi tambahan']);

        // 5. Buat Riwayat Sensor Log (20 data, status bervariasi: Aman / Peringatan / Kritis)
        // Format: [suhu, amonia] -> urutan dari yang TERBARU ke yang TERLAMA
        $dataSensor = [
            [27.4, 12.8], // Aman
            [28.1, 14.2], // Aman
            [30.6, 16.5], // Peringatan (suhu mendekati batas atas & amonia naik)
            [31.2, 18.3], // Peringatan
            [33.5, 22.4], // Kritis (suhu > 32 & amonia > 20)
            [34.1, 25.7], // Kritis
            [31.8, 19.1], // Peringatan
            [29.3, 13.7], // Aman
            [27.9, 12.1], // Aman
            [26.5, 11.4], // Aman
            [25.2, 10.8], // Aman
            [24.6, 13.0], // Peringatan (suhu mendekati batas bawah)
            [22.8, 12.5], // Kritis (suhu < 24)
            [26.8, 17.4], // Peringatan (amonia naik)
            [28.6, 21.3], // Kritis (amonia > 20)
            [29.0, 14.6], // Aman
            [32.6, 20.8], // Kritis
            [30.9, 15.2], // Peringatan
            [27.2, 13.3], // Aman
            [28.4, 12.9], // Aman
        ];

        $waktuSekarang = now();

        foreach ($dataSensor as $i => [$suhu, $amonia]) {
            // Jarak antar data ±2,5 jam, ditambah sedikit variasi menit
            $waktu = (clone $waktuSekarang)->subMinutes(($i * 150) + (($i % 3) * 4));

            SensorLog::create([
                'id_alat'    => $alat->id_alat,
                'suhu'       => $suhu,
                'amonia'     => $amonia,
                'status'     => $this->tentukanStatus($suhu, $amonia, $ambang),
                'created_at' => $waktu,
                'updated_at' => $waktu,
            ]);
        }
    }

    /**
     * Tentukan status sesuai enum di migration: Aman | Peringatan | Kritis
     * - Kritis     : di luar batas ambang
     * - Peringatan : mendekati batas ambang
     * - Aman       : kondisi normal
     */
    private function tentukanStatus(float $suhu, float $amonia, BatasAmbang $ambang): string {
        if ($suhu > $ambang->suhuMax || $suhu < $ambang->suhuMin || $amonia > $ambang->amoniaMax) {
            return 'Kritis';
        }

        if ($suhu >= $ambang->suhuMax - 2 || $suhu <= $ambang->suhuMin + 1 || $amonia >= $ambang->amoniaMax * 0.75) {
            return 'Peringatan';
        }

        return 'Aman';
    }
}
