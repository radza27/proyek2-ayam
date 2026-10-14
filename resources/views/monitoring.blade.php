<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring - Prima Farm</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root { --sidebar-bg: #032b1b; --main-bg: #f8f9fa; }
        body { background-color: var(--main-bg); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        /* Sidebar Styling */
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
        
        /* Main Content Styling */
        .main-content { margin-left: 260px; padding: 25px 35px; }
        .topbar-header { background: #fff; padding: 12px 25px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .card-custom { background: #fff; border: none; border-radius: 16px; box-shadow: 0 2px 6px rgba(0,0,0,0.03); padding: 24px; }
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

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="topbar-header">
            <div class="text-muted small"><i class="fas fa-paper-plane text-warning me-1"></i> Terakhir sinkron: {{ now()->format('d M Y, H:i') }}</div>
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center bg-light px-3 py-1 rounded-pill"><span class="badge bg-warning text-dark rounded-circle p-1 me-2" style="font-size: 10px;">AP</span><span class="fw-bold small">Admin Prima</span></div>
            </div>
        </div>

        <div class="mb-4">
            <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill small mb-1"><i class="fas fa-circle me-1" style="font-size: 6px;"></i> PEMBACAAN SENSOR</span>
            <h3 class="fw-bold mb-0 text-dark">Monitoring</h3>
            <p class="text-muted small mb-0">Pantau kondisi suhu dan gas amonia kandang secara langsung dengan telemetri presisi tinggi.</p>
        </div>

        <!-- Card Tren Sensor -->
        <div class="card-custom mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="fw-bold mb-1"><i class="fas fa-chart-area text-success me-2"></i>Tren Sensor Suhu & Amonia</h5>
                    <p class="text-muted small mb-0">Periode pemantauan siklus sirkulasi kandang broiler (24 Jam Last Log)</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-light px-3 py-1 rounded-pill small">
                        <span class="me-3"><i class="fas fa-circle text-warning fw-bold"></i> Suhu Kandang (°C)</span>
                        <span><i class="fas fa-circle text-success fw-bold"></i> Gas Amonia (ppm)</span>
                    </div>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-dark active px-3">24 Jam</button>
                        <button type="button" class="btn btn-outline-secondary px-3">7 Hari</button>
                    </div>
                </div>
            </div>

            <!-- Canvas Grafik Interaktif (Chart.js) -->
            <div class="bg-white rounded-4 p-3 my-3" style="height: 340px; position: relative;">
                <canvas id="telemetryChart"></canvas>
            </div>

            <!-- Ringkasan Statistik Bawah Grafik -->
            <div class="row g-3 pt-2">
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-3 d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-3 text-warning me-3"><i class="fas fa-temperature-low fa-lg"></i></div>
                        <div><div class="text-muted small">Suhu Rata-rata</div><div class="fw-bold fs-4 text-dark">{{ round($logs->avg('suhu'), 1) }} °C</div></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-3 d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 p-3 rounded-3 text-success me-3"><i class="fas fa-wind fa-lg"></i></div>
                        <div><div class="text-muted small">Amonia Rata-rata</div><div class="fw-bold fs-4 text-dark">{{ round($logs->avg('amonia'), 1) }} ppm</div></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-3 d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-primary me-3"><i class="fas fa-sync fa-lg"></i></div>
                        <div><div class="text-muted small">Pembaruan Rutin</div><div class="fw-bold fs-4 text-dark">Tiap 5 Detik</div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Pengolahan Chart.js dengan Data dari Laravel -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('telemetryChart').getContext('2d');

            // Extraction data log dari Laravel $logs
            const labels = [
                @foreach($logs as $log)
                    "{{ \Carbon\Carbon::parse($log->created_at)->format('H:i') }}",
                @endforeach
            ];

            const dataSuhu = [
                @foreach($logs as $log)
                    {{ $log->suhu }},
                @endforeach
            ];

            const dataAmonia = [
                @foreach($logs as $log)
                    {{ $log->amonia }},
                @endforeach
            ];

            // Gradient background Suhu (Orange/Kuning)
            const gradientSuhu = ctx.createLinearGradient(0, 0, 0, 300);
            gradientSuhu.addColorStop(0, 'rgba(255, 152, 0, 0.35)');
            gradientSuhu.addColorStop(1, 'rgba(255, 152, 0, 0.0)');

            // Gradient background Amonia (Hijau Tua)
            const gradientAmonia = ctx.createLinearGradient(0, 0, 0, 300);
            gradientAmonia.addColorStop(0, 'rgba(3, 43, 27, 0.25)');
            gradientAmonia.addColorStop(1, 'rgba(3, 43, 27, 0.0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Suhu Kandang (°C)',
                            data: dataSuhu,
                            borderColor: '#ff9800',
                            backgroundColor: gradientSuhu,
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#ff9800',
                            pointRadius: 4,
                            pointHoverRadius: 6
                        },
                        {
                            label: 'Gas Amonia (ppm)',
                            data: dataAmonia,
                            borderColor: '#032b1b',
                            backgroundColor: gradientAmonia,
                            borderWidth: 2,
                            borderDash: [5, 5],
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#032b1b',
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: '#032b1b',
                            padding: 12,
                            cornerRadius: 8
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#6c757d', font: { size: 11 } }
                        },
                        y: {
                            grid: { color: 'rgba(0, 0, 0, 0.04)' },
                            ticks: { color: '#6c757d', font: { size: 11 } }
                        }
                    }
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>