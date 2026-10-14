<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // 1. Buat tabel users terlebih dahulu
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_akun');
            $table->string('nama');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        // 2. Buat tabel alats
        Schema::create('alats', function (Blueprint $table) {
            $table->id('id_alat');
            $table->unsignedBigInteger('id_akun');
            $table->foreign('id_akun')->references('id_akun')->on('users')->onDelete('cascade');
            $table->string('nama');
            $table->string('lokasi');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        // 3. Buat tabel sensor_logs
        Schema::create('sensor_logs', function (Blueprint $table) {
            $table->id('id_sensorlog');
            $table->foreignId('id_alat')->constrained('alats', 'id_alat')->onDelete('cascade');
            $table->float('suhu');
            $table->float('amonia');
            $table->enum('status', ['Aman', 'Kritis', 'Peringatan'])->default('Aman');
            $table->timestamps();
        });

        // 4. Buat tabel aktuators
        Schema::create('aktuators', function (Blueprint $table) {
            $table->id('id_aktuator');
            $table->foreignId('id_alat')->constrained('alats', 'id_alat')->onDelete('cascade');
            $table->string('nama');
            $table->string('relay_code');
            $table->boolean('otomatisasi')->default(true);
            $table->boolean('status')->default(false);
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });

        // 5. Buat tabel batas_ambangs
        Schema::create('batas_ambangs', function (Blueprint $table) {
            $table->id('id_ambang');
            $table->foreignId('id_alat')->constrained('alats', 'id_alat')->onDelete('cascade');
            $table->float('suhuMin')->default(24);
            $table->float('suhuMax')->default(32);
            $table->float('amoniaMax')->default(20);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('batas_ambangs');
        Schema::dropIfExists('aktuators');
        Schema::dropIfExists('sensor_logs');
        Schema::dropIfExists('alats');
        Schema::dropIfExists('users');
    }
};