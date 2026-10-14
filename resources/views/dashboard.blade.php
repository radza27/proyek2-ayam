<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kandang - Prima Farm</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .card-custom { background: #fff; border: none; border-radius: 16px; box-shadow: 0 2px 6px rgba(0,0,0,0.03); padding: 20px; height: 100%; }
        .form-check-input:checked { background-color: #032b1b; border-color: #032b1b; }
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

    <!-- KONTEN UTAMA -->
    <div class="main-content">
        <div class="topbar-header">
            <div class="text-muted small"><i class="fas fa-paper-plane text-warning me-1"></i> Terakhir sinkron: {{ now()->format('d M Y, H:i') }}</div>
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light btn-sm rounded-circle shadow-sm" style="width: 35px; height: 35px;"><i class="fas fa-sync-alt text-secondary"></i></button>
                <div class="d-flex align-items-center bg-light px-3 py-1 rounded-pill">
                    <span class="badge bg-warning text-dark rounded-circle p-1 me-2" style="font-size: 10px;">AP</span>
                    <span class="fw-bold small">Admin Prima</span>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill small mb-1"><i class="fas fa-circle me-1" style="font-size: 6px;"></i> RINGKASAN KANDANG</span>
                <h3 class="fw-bold mb-0 text-dark">Dashboard Kandang</h3>
                <p class="text-muted small mb-0">Rangkuman lengkap kondisi kandang, pembacaan sensor live, status aktuator, dan log riwayat.</p>
            </div>
            <div>
                <span class="badge bg-success bg-opacity-25 text-success px-3 py-2 fw-bold rounded-pill"><i class="fas fa-shield-alt me-1"></i> Status Kandang: AMAN & STABIL</span>
            </div>
        </div>

        <!-- 3 Card Utama -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card-custom">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-3 text-warning"><i class="fas fa-temperature-high fa-lg"></i></div>
                        <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill small">LIVE</span>
                    </div>
                    <span class="text-muted small text-uppercase fw-semibold">Suhu Kandang</span>
                    <h2 class="fw-bold display-5 my-1">{{ $latestLog->suhu ?? '0' }} <span class="fs-4 text-muted">°C</span></h2>
                    <div class="mt-3 pt-2 border-top text-muted small"><i class="fas fa-check-circle text-success me-1"></i> Dalam batas aman <span class="text-dark fw-semibold">Batas {{ $alat->batasAmbang->suhuMin ?? 24 }}–{{ $alat->batasAmbang->suhuMax ?? 32 }}°C</span></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-custom">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="bg-success bg-opacity-10 p-3 rounded-3 text-success"><i class="fas fa-smog fa-lg"></i></div>
                        <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill small">LIVE</span>
                    </div>
                    <span class="text-muted small text-uppercase fw-semibold">Gas Amonia</span>
                    <h2 class="fw-bold display-5 my-1">{{ $latestLog->amonia ?? '0' }} <span class="fs-4 text-muted">ppm</span></h2>
                    <div class="mt-3 pt-2 border-top text-muted small"><i class="fas fa-check-circle text-success me-1"></i> Kualitas udara baik <span class="text-dark fw-semibold">Batas &lt; {{ $alat->batasAmbang->amoniaMax ?? 20 }} ppm</span></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-custom">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-primary"><i class="fas fa-wifi fa-lg"></i></div>
                        <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 rounded-pill small">ESP32 Node</span>
                    </div>
                    <span class="text-muted small text-uppercase fw-semibold">Status Sensor</span>
                    <h2 class="fw-bold display-6 my-2 text-dark">Online <i class="fas fa-check-circle text-success fs-5"></i></h2>
                    <div class="mt-3 pt-2 border-top d-flex gap-2">
                        <span class="badge bg-light text-secondary border small">DHT22 Aktif</span>
                        <span class="badge bg-light text-secondary border small">MQ-135 Aktif</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Baris Grafik & Kendali Aktuator -->
        <div class="row g-4 mb-4">
            <!-- Grafik Tren Dashboard -->
            <div class="col-md-8">
                <div class="card-custom">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="fw-bold mb-1">Tren Sensor (Suhu & Amonia)</h5>
                            <p class="text-muted small mb-0">Periode Pemantauan Siklus Kandang Broiler</p>
                        </div>
                        <div class="d-flex gap-2 small text-muted">
                            <span><i class="fas fa-circle text-warning small"></i> Suhu (°C)</span>
                            <span><i class="fas fa-circle text-success small"></i> Amonia (ppm)</span>
                        </div>
                    </div>
                    <!-- Canvas Chart.js -->
                    <div class="bg-white rounded-3 p-2" style="height: 230px; position: relative;">
                        <canvas id="dashboardChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Kendali Aktuator -->
            <div class="col-md-4">
                <div class="card-custom">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0 fs-6">Status & Kendali Aktuator</h5>
                        <span class="badge bg-success bg-opacity-10 text-success small px-2 py-1">OTOMATIS</span>
                    </div>
                    <div class="d-flex flex-column gap-3">
                        @forelse($aktuators as $akt)
                            <div class="p-2 border rounded-3 bg-light d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold small text-dark">{{ $akt->nama }}</div>
                                    <div class="text-muted" style="font-size: 11px;">{{ $akt->status ? 'Menyala (Aktif)' : 'Mati (Standby)' }}</div>
                                </div>
                                <form action="{{ route('aktuator.toggle', $akt->id_aktuator) }}" method="POST">
                                    @csrf
                                    <div class="form-check form-switch m-0">
                                        <input class="form-check-input" type="checkbox" role="switch" {{ $akt->status ? 'checked' : '' }} onChange="this.form.submit()" style="cursor: pointer;">
                                    </div>
                                </form>
                            </div>
                        @empty
                            <div class="text-muted small text-center">Belum ada aktuator terdaftar.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Riwayat & Ambang Batas -->
        <div class="row g-4">
            <div class="col-md-8">
                <div class="card-custom">
                    <h5 class="fw-bold mb-3 fs-6">Riwayat Pembacaan Terakhir</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 small">
                            <thead class="table-light">
                                <tr>
                                    <th>Waktu</th>
                                    <th>Suhu (°C)</th>
                                    <th>Amonia (ppm)</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($log->created_at)->format('H:i:s WIB') }}</td>
                                        <td class="fw-bold text-danger">{{ $log->suhu }} °C</td>
                                        <td class="fw-bold text-success">{{ $log->amonia }} ppm</td>
                                        <td><span class="badge bg-success bg-opacity-25 text-success">{{ $log->status ?? 'Aman' }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted">Belum ada data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-custom">
                    <h5 class="fw-bold mb-3 fs-6">Ambang Batas Pengaturan Aktif</h5>
                    <div class="d-flex flex-column gap-2">
                        <div class="p-2 bg-light rounded-3 d-flex justify-content-between align-items-center">
                            <div><span class="text-muted small d-block">Suhu Min</span><h6 class="fw-bold mb-0">{{ $alat->batasAmbang->suhuMin ?? 24 }} °C</h6></div>
                            <span class="badge bg-warning bg-opacity-25 text-dark small">Pemanas</span>
                        </div>
                        <div class="p-2 bg-light rounded-3 d-flex justify-content-between align-items-center">
                            <div><span class="text-muted small d-block">Suhu Maks</span><h6 class="fw-bold mb-0">{{ $alat->batasAmbang->suhuMax ?? 32 }} °C</h6></div>
                            <span class="badge bg-danger bg-opacity-25 text-danger small">Exhaust</span>
                        </div>
                        <div class="p-2 bg-light rounded-3 d-flex justify-content-between align-items-center">
                            <div><span class="text-muted small d-block">Amonia Maks</span><h6 class="fw-bold mb-0">{{ $alat->batasAmbang->amoniaMax ?? 20 }} ppm</h6></div>
                            <span class="badge bg-success bg-opacity-25 text-success small">Sirkulasi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Chart.js untuk Dashboard -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('dashboardChart').getContext('2d');

            const labels = [
                @foreach($logs->reverse() as $log)
                    "{{ \Carbon\Carbon::parse($log->created_at)->format('H:i') }}",
                @endforeach
            ];

            const dataSuhu = [
                @foreach($logs->reverse() as $log)
                    {{ $log->suhu }},
                @endforeach
            ];

            const dataAmonia = [
                @foreach($logs->reverse() as $log)
                    {{ $log->amonia }},
                @endforeach
            ];

            const gradientSuhu = ctx.createLinearGradient(0, 0, 0, 200);
            gradientSuhu.addColorStop(0, 'rgba(255, 152, 0, 0.3)');
            gradientSuhu.addColorStop(1, 'rgba(255, 152, 0, 0.0)');

            const gradientAmonia = ctx.createLinearGradient(0, 0, 0, 200);
            gradientAmonia.addColorStop(0, 'rgba(3, 43, 27, 0.2)');
            gradientAmonia.addColorStop(1, 'rgba(3, 43, 27, 0.0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Suhu (°C)',
                            data: dataSuhu,
                            borderColor: '#ff9800',
                            backgroundColor: gradientSuhu,
                            borderWidth: 2.5,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 3
                        },
                        {
                            label: 'Amonia (ppm)',
                            data: dataAmonia,
                            borderColor: '#032b1b',
                            backgroundColor: gradientAmonia,
                            borderWidth: 2,
                            borderDash: [4, 4],
                            fill: true,
                            tension: 0.4,
                            pointRadius: 3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, ticks: { font: { size: 10 } } },
                        y: { grid: { color: 'rgba(0,0,0,0.03)' }, ticks: { font: { size: 10 } } }
                    }
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>