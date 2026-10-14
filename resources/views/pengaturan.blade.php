<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - Prima Farm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-bg: #032b1b; --main-bg: #f8f9fa; }
        body { background-color: var(--main-bg); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { width: 260px; height: 100vh; background-color: var(--sidebar-bg); position: fixed; top: 0; left: 0; display: flex; flex-direction: column; justify-content: space-between; padding: 20px; color: #fff; z-index: 100; }
        .sidebar-brand { font-size: 1.1rem; font-weight: bold; display: flex; align-items: center; color: #fff; text-decoration: none; margin-bottom: 30px; }
        .sidebar-brand .logo-icon { background-color: #ff9800; color: #fff; padding: 8px 10px; border-radius: 8px; margin-right: 10px; }
        .nav-menu { list-style: none; padding: 0; margin: 0; }
        .nav-item { margin-bottom: 8px; }
        .nav-link { color: #a3b8af; text-decoration: none; display: flex; align-items: center; padding: 10px 15px; border-radius: 8px; font-size: 0.95rem; transition: all 0.2s; }
        .nav-link i { margin-right: 12px; width: 20px; }
        .nav-link:hover, .nav-link.active { background-color: #053f29; color: #fff; }
        .sidebar-gateway { background-color: #053f29; border-radius: 10px; padding: 12px 15px; font-size: 0.85rem; margin-bottom: 12px; }
        .sidebar-user { background-color: #053f29; border-radius: 10px; padding: 12px 15px; display: flex; align-items: center; justify-content: space-between; }
        .main-content { margin-left: 260px; padding: 25px 35px; }
        .topbar-header { background: #fff; padding: 12px 25px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .card-custom { background: #fff; border: none; border-radius: 16px; box-shadow: 0 2px 6px rgba(0,0,0,0.03); padding: 24px; }

        /* --- ANIMASI MASUK CARD PENGATURAN (FADE IN & SLIDE UP) --- */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-card {
            animation: fadeInUp 0.45s ease forwards;
            opacity: 0; /* Awalnya transparan */
        }
    </style>
</head>
<body>
    <!-- SIDEBAR KIRI -->
<div class="sidebar">
    <div>
        <!-- Brand / Logo Prima Farm -->
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <span class="logo-icon"><i class="fas fa-feather-alt"></i></span> PRIMA FARM
        </a>

        <!-- Menu Navigasi Utama -->
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('monitoring') }}" class="nav-link {{ request()->routeIs('monitoring') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i> Monitoring
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('riwayat') }}" class="nav-link {{ request()->routeIs('riwayat') ? 'active' : '' }}">
                    <i class="fas fa-history"></i> Riwayat Data
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('aktuator') }}" class="nav-link {{ request()->routeIs('aktuator') ? 'active' : '' }}">
                    <i class="fas fa-sliders-h"></i> Kendali Aktuator
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pengaturan') }}" class="nav-link {{ request()->routeIs('pengaturan') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i> Pengaturan
                </a>
            </li>
        </ul>
    </div>

    <div>
        <!-- Card Status ESP32 Gateway -->
        <div class="sidebar-gateway">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="fw-bold"><i class="fas fa-wifi me-1"></i> ESP32 Gateway</span>
                <i class="fas fa-signal text-success small"></i>
            </div>
            <div class="text-muted small mb-2">{{ $alat->nama ?? 'Biosecurity Node A' }}</div>
            <span class="badge bg-success bg-opacity-25 text-success small px-2 py-1">
                <i class="fas fa-circle" style="font-size: 6px;"></i> Terhubung
            </span>
        </div>

        <!-- Card Informasi User & Form Logout -->
        <div class="sidebar-user">
            <div class="d-flex align-items-center">
                <div class="bg-warning text-dark fw-bold rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 12px;">
                    {{ strtoupper(substr(Auth::user()->nama ?? 'AP', 0, 2)) }}
                </div>
                <div>
                    <div class="fw-bold small text-white">{{ Auth::user()->nama ?? 'Admin Prima Farm' }}</div>
                    <div class="text-muted" style="font-size: 11px;">Peternak / Admin</div>
                </div>
            </div>

            <!-- FORM LOGOUT DENGAN IKON KLIK -->
            <form action="{{ route('logout') }}" method="POST" class="d-inline m-0">
                @csrf
                <button type="submit" class="btn btn-link text-muted p-0 border-0 align-middle" title="Keluar dari akun" style="text-decoration: none;">
                    <i class="fas fa-sign-out-alt" style="cursor: pointer; font-size: 1.1rem;"></i>
                </button>
            </form>
        </div>
    </div>
</div>

    <div class="main-content">
        <div class="topbar-header">
            <div class="text-muted small"><i class="fas fa-paper-plane text-warning me-1"></i> Terakhir sinkron: {{ now()->format('d M Y, H:i') }}</div>
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center bg-light px-3 py-1 rounded-pill"><span class="badge bg-warning text-dark rounded-circle p-1 me-2" style="font-size: 10px;">AP</span><span class="fw-bold small">Admin Prima</span></div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 animate-card" style="animation-delay: 0s;" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="mb-4">
            <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill small mb-1"><i class="fas fa-circle me-1" style="font-size: 6px;"></i> KONFIGURASI</span>
            <h3 class="fw-bold mb-0 text-dark">Pengaturan Ambang Batas</h3>
            <p class="text-muted small mb-0">Tentukan batas aman suhu dan kadar amonia kandang.</p>
        </div>

        <div class="card-custom">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded-3 text-success me-3"><i class="fas fa-sliders-h fa-lg"></i></div>
                    <div>
                        <h5 class="fw-bold mb-1">Ambang Batas Sensor</h5>
                        <p class="text-muted small mb-0">Sesuaikan batas aman yang digunakan untuk menentukan status kandang.</p>
                    </div>
                </div>
                <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill small"><i class="fas fa-circle text-success me-1" style="font-size: 6px;"></i> ESP32 Biosecurity A</span>
            </div>

            <!-- Form Update Ambang Batas -->
            <form action="{{ route('ambang.update') }}" method="POST">
                @csrf
                <div class="row g-4 mb-4">
                    <!-- Suhu Minimum -->
                    <div class="col-md-4 animate-card" style="animation-delay: 0.05s;">
                        <div class="p-4 rounded-4 bg-light border">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold text-dark"><i class="fas fa-snowflake text-warning me-1"></i> Suhu Minimum</span>
                                <span class="badge bg-secondary bg-opacity-25 text-dark small">Batas Bawah</span>
                            </div>
                            <p class="text-muted small mb-3">Memicu sistem pemanas kandang</p>
                            <div class="input-group mb-2">
                                <input type="number" step="0.1" name="suhuMin" class="form-control form-control-lg fw-bold text-center border-0 bg-white shadow-sm" value="{{ $ambang->suhuMin ?? 24 }}">
                                <span class="input-group-text bg-white border-0 fw-bold">°C</span>
                            </div>
                            <small class="text-muted">Rekomendasi broiler: 22 - 25 °C</small>
                        </div>
                    </div>

                    <!-- Suhu Maksimum -->
                    <div class="col-md-4 animate-card" style="animation-delay: 0.12s;">
                        <div class="p-4 rounded-4 bg-light border">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold text-dark"><i class="fas fa-fire text-danger me-1"></i> Suhu Maksimum</span>
                                <span class="badge bg-secondary bg-opacity-25 text-dark small">Batas Atas</span>
                            </div>
                            <p class="text-muted small mb-3">Memicu kipas exhaust otomatis</p>
                            <div class="input-group mb-2">
                                <input type="number" step="0.1" name="suhuMax" class="form-control form-control-lg fw-bold text-center border-0 bg-white shadow-sm" value="{{ $ambang->suhuMax ?? 32 }}">
                                <span class="input-group-text bg-white border-0 fw-bold">°C</span>
                            </div>
                            <small class="text-muted">Rekomendasi broiler: 30 - 33 °C</small>
                        </div>
                    </div>

                    <!-- Amonia Maksimum -->
                    <div class="col-md-4 animate-card" style="animation-delay: 0.19s;">
                        <div class="p-4 rounded-4 bg-light border">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold text-dark"><i class="fas fa-wind text-success me-1"></i> Amonia Maksimum</span>
                                <span class="badge bg-danger bg-opacity-25 text-danger small">Kritis</span>
                            </div>
                            <p class="text-muted small mb-3">Memicu sirkulasi darurat</p>
                            <div class="input-group mb-2">
                                <input type="number" step="0.1" name="amoniaMax" class="form-control form-control-lg fw-bold text-center border-0 bg-white shadow-sm" value="{{ $ambang->amoniaMax ?? 20 }}">
                                <span class="input-group-text bg-white border-0 fw-bold">ppm</span>
                            </div>
                            <small class="text-muted">Standar biosekuriti: &le; 20 ppm</small>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <span class="text-muted small"><i class="fas fa-check-circle text-success me-1"></i> Parameter akan langsung disinkronkan ke unit relay mikrokontroler.</span>
                    <div class="d-flex gap-2">
                        <button type="reset" class="btn btn-light px-4 rounded-pill">Reset Nilai</button>
                        <button type="submit" class="btn btn-success px-4 rounded-pill fw-bold" style="background-color: #032b1b;"><i class="fas fa-save me-1"></i> Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>