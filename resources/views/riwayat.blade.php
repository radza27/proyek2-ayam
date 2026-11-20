<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Data - Prima Farm</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-bg: #032b1b; --main-bg: #f8f9fa; }
        body { background-color: var(--main-bg); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #1e293b; }

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

        /* Main Content & Topbar */
        .main-content { margin-left: 260px; padding: 25px 35px; }
        .topbar-header { background: #fff; padding: 12px 25px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .card-custom { background: #fff; border: none; border-radius: 16px; box-shadow: 0 2px 6px rgba(0,0,0,0.03); padding: 24px; margin-bottom: 24px; }

        /* Filter Pills */
        .filter-pill {
            background-color: #f1f5f9;
            color: #475569;
            border: 1px solid transparent;
            border-radius: 10px;
            padding: 8px 16px;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.2s;
            cursor: pointer;
        }
        .filter-pill:hover { background-color: #e2e8f0; color: #032b1b; }
        .filter-pill.active {
            background-color: #032b1b;
            color: #ffffff;
            font-weight: 600;
        }
        .btn-export-dark {
            background-color: #032b1b;
            color: #fff;
            border-radius: 10px;
            padding: 8px 18px;
            font-size: 0.85rem;
            font-weight: 600;
            border: none;
            transition: 0.2s;
        }
        .btn-export-dark:hover { background-color: #06442c; color: #fff; }

        /* Table Styling */
        .table-custom { border-collapse: separate; border-spacing: 0 8px; }
        .table-custom thead th {
            background-color: #f8fafc;
            color: #64748b;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border: none;
            padding: 12px 16px;
        }
        .table-custom thead th:first-child { border-top-left-radius: 10px; border-bottom-left-radius: 10px; }
        .table-custom thead th:last-child { border-top-right-radius: 10px; border-bottom-right-radius: 10px; }

        .table-custom tbody tr { background-color: #ffffff; transition: 0.2s; }
        .table-custom tbody tr:nth-child(even) { background-color: #f8fafc; }
        .table-custom tbody tr:hover { background-color: #f1f5f9; }
        .table-custom tbody td { border: none; padding: 14px 16px; vertical-align: middle; }
        .table-custom tbody td:first-child { border-top-left-radius: 10px; border-bottom-left-radius: 10px; }
        .table-custom tbody td:last-child { border-top-right-radius: 10px; border-bottom-right-radius: 10px; }

        .dot-indicator { width: 7px; height: 7px; border-radius: 50%; display: inline-block; margin-right: 6px; }
        .badge-status-aman { background-color: #dcfce7; color: #15803d; padding: 5px 12px; border-radius: 20px; font-weight: 600; font-size: 0.78rem; }
        .badge-status-waspada { background-color: #fef3c7; color: #b45309; padding: 5px 12px; border-radius: 20px; font-weight: 600; font-size: 0.78rem; }

        /* Sort Select Box */
        .sort-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 6px 14px;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
        }
        .sort-box select {
            border: none;
            background: transparent;
            font-weight: 600;
            color: #0f172a;
            outline: none;
            cursor: pointer;
            margin-left: 6px;
        }

        /* Pagination */
        .pagination { margin-bottom: 0; }
        .pagination .page-item .page-link {
            border: none;
            color: #475569;
            background-color: #f1f5f9;
            font-weight: 600;
            padding: 6px 13px;
            border-radius: 8px !important;
            margin: 0 3px;
            font-size: 0.85rem;
        }
        .pagination .page-item.active .page-link { background-color: #032b1b; color: #fff; }
        .pagination .page-item.disabled .page-link { color: #cbd5e1; background-color: #f8fafc; }
        .pagination svg { width: 15px !important; height: 15px !important; }
        nav[role="navigation"] { display: flex; justify-content: space-between; align-items: center; width: 100%; }

        /* Animasi */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-row { animation: fadeInUp 0.35s ease forwards; opacity: 0; }
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
        <!-- TOPBAR -->
        <div class="topbar-header">
            <div class="text-muted small"><i class="fas fa-paper-plane text-warning me-1"></i> Terakhir sinkron: {{ now()->format('d M Y, H:i') }}</div>
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center bg-light px-3 py-1 rounded-pill">
                    <span class="badge bg-warning text-dark rounded-circle p-1 me-2" style="font-size: 10px;">AP</span>
                    <span class="fw-bold small">Admin Prima</span>
                </div>
            </div>
        </div>

        <!-- HEADER JUDUL -->
        <div class="mb-4">
            <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill small mb-1"><i class="fas fa-circle me-1" style="font-size: 6px;"></i> DATA SENSOR</span>
            <h3 class="fw-bold mb-0 text-dark">Riwayat Data</h3>
            <p class="text-muted small mb-0">Lihat dan analisis data pembacaan sensor yang tersimpan.</p>
        </div>

        <!-- CARD 1: FILTERING & EKSPOR CSV -->
        @php
            $activeFilter = request('filter', 'minggu_ini');
            $currentSort = request('sort', 'terbaru');
        @endphp
        <div class="card-custom">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-3">
                <div>
                    <h5 class="fw-bold mb-1 text-dark">Riwayat Kondisi Kandang</h5>
                    <p class="text-muted small mb-0">Filter pencatatan suhu dan kadar amonia berdasarkan rentang waktu.</p>
                </div>

                <a href="{{ route('riwayat.export', request()->query()) }}" class="btn btn-export-dark">
                    <i class="fas fa-download me-2"></i> Ekspor CSV
                </a>
            </div>

            <!-- Baris Tombol Filter Waktu -->
            <div class="d-flex flex-wrap align-items-center gap-2 pt-1">
                <a href="{{ route('riwayat', ['filter' => 'hari_ini', 'sort' => $currentSort]) }}"
                   class="filter-pill {{ $activeFilter == 'hari_ini' ? 'active' : '' }}">
                    Hari ini
                </a>
                <a href="{{ route('riwayat', ['filter' => '3_hari', 'sort' => $currentSort]) }}"
                   class="filter-pill {{ $activeFilter == '3_hari' ? 'active' : '' }}">
                    3 hari terakhir
                </a>
                <a href="{{ route('riwayat', ['filter' => 'minggu_ini', 'sort' => $currentSort]) }}"
                   class="filter-pill {{ $activeFilter == 'minggu_ini' ? 'active' : '' }}">
                    Minggu ini
                </a>
                <a href="{{ route('riwayat', ['filter' => '10_hari', 'sort' => $currentSort]) }}"
                   class="filter-pill {{ $activeFilter == '10_hari' ? 'active' : '' }}">
                    10 hari terakhir
                </a>
                <a href="{{ route('riwayat', ['filter' => 'bulan_ini', 'sort' => $currentSort]) }}"
                   class="filter-pill {{ $activeFilter == 'bulan_ini' ? 'active' : '' }}">
                    Bulan ini
                </a>

                <button type="button" class="filter-pill {{ $activeFilter == 'custom' ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#customDateBox">
                    <i class="far fa-calendar-alt me-2"></i> Pilih tanggal
                </button>
            </div>

            <!-- Form Collapse Pilih Tanggal Kustom -->
            <div class="collapse {{ $activeFilter == 'custom' ? 'show' : '' }} mt-3" id="customDateBox">
                <form action="{{ route('riwayat') }}" method="GET" class="row g-2 align-items-end bg-light p-3 rounded-3">
                    <input type="hidden" name="filter" value="custom">
                    <input type="hidden" name="sort" value="{{ $currentSort }}">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-muted mb-1">Dari Tanggal</label>
                        <input type="date" name="start_date" class="form-control form-control-sm" value="{{ request('start_date') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-muted mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" class="form-control form-control-sm" value="{{ request('end_date') }}" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-export-dark btn-sm w-100">
                            <i class="fas fa-filter me-1"></i> Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- CARD 2: TABEL LOG PEMBACAAN TELEMETRI -->
        <div class="card-custom">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-10 text-success rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-table"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0 text-dark">Log Pembacaan Telemetri</h5>
                        <p class="text-muted small mb-0">Daftar rekaman berkala dari node kandang</p>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <form action="{{ route('riwayat') }}" method="GET" id="sortForm" class="m-0">
                        <input type="hidden" name="filter" value="{{ $activeFilter }}">
                        @if(request('start_date')) <input type="hidden" name="start_date" value="{{ request('start_date') }}"> @endif
                        @if(request('end_date')) <input type="hidden" name="end_date" value="{{ request('end_date') }}"> @endif

                        <div class="sort-box">
                            <span class="text-muted">Urutkan:</span>
                            <select name="sort" onchange="document.getElementById('sortForm').submit()">
                                <option value="terbaru" {{ $currentSort == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                <option value="terlama" {{ $currentSort == 'terlama' ? 'selected' : '' }}>Terlama</option>
                            </select>
                        </div>
                    </form>

                    <a href="{{ request()->fullUrl() }}" class="btn btn-light border rounded-3 px-3 py-2 text-dark" title="Muat Ulang Tabel">
                        <i class="fas fa-redo-alt small"></i>
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-custom align-middle mb-3">
                    <thead>
                        <tr>
                            <th>TANGGAL & WAKTU</th>
                            <th>SUHU</th>
                            <th>GAS AMONIA</th>
                            <th>STATUS</th>
                            <th>SUMBER</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $index => $log)
                            @php
                                $waktu = \Carbon\Carbon::parse($log->created_at);
                                $isWaspada = ($log->suhu > 30 || $log->amonia >= 20 || ($log->status && strtolower($log->status) !== 'aman'));
                            @endphp
                            <tr class="animate-row" style="animation-delay: {{ $index * 0.04 }}s;">
                                <td>
                                    <div class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $waktu->format('d M Y, H:i') }} WIB</div>
                                    <div class="text-muted" style="font-size: 0.78rem;">{{ $waktu->diffForHumans() }}</div>
                                </td>
                                <td>
                                    <span class="dot-indicator bg-warning"></span>
                                    <span class="fw-bold text-dark">{{ number_format($log->suhu, 1) }}°C</span>
                                </td>
                                <td>
                                    <span class="dot-indicator bg-success"></span>
                                    <span class="fw-bold text-dark">{{ number_format($log->amonia, 1) }} ppm</span>
                                </td>
                                <td>
                                    @if($isWaspada)
                                        <span class="badge-status-waspada">
                                            <i class="fas fa-circle me-1" style="font-size: 6px;"></i> {{ $log->status ?? 'Waspada' }}
                                        </span>
                                    @else
                                        <span class="badge-status-aman">
                                            <i class="fas fa-circle me-1" style="font-size: 6px;"></i> {{ $log->status ?? 'Aman' }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-muted small fw-medium"><i class="fas fa-wifi me-1"></i> {{ $log->sumber ?? 'ESP32-01' }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fas fa-folder-open fa-2x mb-2 text-secondary opacity-50"></i>
                                    <div>Tidak ada riwayat data log pada rentang waktu yang dipilih.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- FOOTER TABEL & PAGINATION -->
            <div class="d-flex flex-wrap justify-content-between align-items-center pt-3 border-top">
                <div class="text-muted small">
                    @if($logs->total() > 0)
                        Menampilkan <strong>{{ $logs->firstItem() }} – {{ $logs->lastItem() }}</strong> dari <strong>{{ $logs->total() }}</strong> baris data
                    @else
                        Menampilkan 0 baris data
                    @endif
                </div>
                <div>
                    {{ $logs->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>