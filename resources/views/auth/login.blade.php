<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Prima Farm</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: #ffffff;
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 480px;
            padding: 40px;
        }
        .brand-logo {
            background-color: #ff9800;
            color: #fff;
            padding: 10px 14px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        .form-control:focus {
            border-color: #032b1b;
            box-shadow: 0 0 0 0.25rem rgba(3, 43, 27, 0.10);
        }
        .btn-custom {
            background-color: #032b1b;
            color: #fff;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            transition: background 0.2s;
        }
        .btn-custom:hover {
            background-color: #053f29;
            color: #fff;
        }
        .form-check-input:checked {
            background-color: #032b1b;
            border-color: #032b1b;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <!-- Header Logo & Status Server -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center gap-2">
                <div class="brand-logo"><i class="fas fa-feather-alt"></i></div>
                <span class="fw-bold fs-5 text-dark">PRIMA FARM</span>
            </div>
            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill small fw-semibold">
                <i class="fas fa-circle me-1" style="font-size: 6px;"></i> SERVER ONLINE
            </span>
        </div>

        <div class="mb-4">
            <span class="text-muted small text-uppercase fw-semibold d-block mb-1">Akses Pengguna</span>
            <h3 class="fw-bold text-dark mb-1">Selamat datang kembali</h3>
            <p class="text-muted small mb-0">Masuk menggunakan akun peternak atau admin yang terdaftar.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show small py-2 mb-3" role="alert">
                {{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show small py-2 mb-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Form Login -->
        <form action="{{ route('login.process') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label small fw-bold text-secondary">Alamat email</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted ps-3"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="email" class="form-control bg-light border-start-0 py-2 ps-2" placeholder="admin@primafarm.id" value="{{ old('email') }}" required>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label small fw-bold text-secondary mb-1">Kata sandi</label>
                    <a href="#" class="text-muted small text-decoration-none" style="font-size: 12px;">Lupa kata sandi?</a>
                </div>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted ps-3"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" id="passwordField" class="form-control bg-light border-start-0 border-end-0 py-2 ps-2" placeholder="Masukan kata sandi" required>
                    <span class="input-group-text bg-light border-start-0 text-muted pe-3" id="togglePassword" style="cursor: pointer;"><i class="fas fa-eye"></i></span>
                </div>
            </div>

            <div class="mb-4 d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                    <label class="form-check-label small text-secondary" for="rememberMe">Ingat saya di perangkat ini</label>
                </div>
            </div>

            <button type="submit" class="btn btn-custom w-100 shadow-sm d-flex justify-content-center align-items-center gap-2">
                <span>Masuk ke Dashboard</span> <i class="fas fa-arrow-right"></i>
            </button>
        </form>
    </div>

    <!-- Script Toggle Password View -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordField = document.querySelector('#passwordField');

        togglePassword.addEventListener('click', function () {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>