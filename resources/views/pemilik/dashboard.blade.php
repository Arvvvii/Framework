<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemilik Dashboard - Veterinary Hospital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .dashboard-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            margin: 20px;
            padding: 30px;
        }
        .header-section {
            background: linear-gradient(135deg, #FF6B6B, #ee5a52);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .stats-icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }
        .menu-section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .menu-item {
            display: flex;
            align-items: center;
            padding: 15px;
            margin-bottom: 10px;
            background: #f8f9fa;
            border-radius: 10px;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #333;
        }
        .menu-item:hover {
            background: #e9ecef;
            transform: translateX(5px);
        }
        .menu-icon {
            margin-right: 15px;
            font-size: 1.5rem;
            color: #FF6B6B;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="dashboard-container">
            <!-- Header Section -->
            <div class="header-section">
                <h1><i class="fas fa-user"></i> Pemilik Dashboard</h1>
                <p class="mb-0">Kelola Hewan Peliharaan Anda dengan Mudah</p>
            </div>

            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-md-4">
                    <div class="stats-card text-center">
                        <div class="stats-icon text-primary">
                            <i class="fas fa-paw"></i>
                        </div>
                        <h3 class="text-primary">3</h3>
                        <p class="mb-0">Hewan Peliharaan</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card text-center">
                        <div class="stats-icon text-success">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h3 class="text-success">2</h3>
                        <p class="mb-0">Kunjungan Bulan Ini</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card text-center">
                        <div class="stats-icon text-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3 class="text-warning">1</h3>
                        <p class="mb-0">Jadwal Mendatang</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Menu -->
            <div class="menu-section">
                <h4 class="mb-4"><i class="fas fa-tasks"></i> Menu Cepat</h4>
                <div class="row">
                    <div class="col-md-6">
                        <a href="#" class="menu-item">
                            <div class="menu-icon">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Daftar Hewan Baru</h6>
                                <small class="text-muted">Tambahkan hewan peliharaan baru</small>
                            </div>
                        </a>
                        <a href="#" class="menu-item">
                            <div class="menu-icon">
                                <i class="fas fa-calendar-plus"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Buat Janji</h6>
                                <small class="text-muted">Jadwalkan kunjungan ke dokter</small>
                            </div>
                        </a>
                        <a href="#" class="menu-item">
                            <div class="menu-icon">
                                <i class="fas fa-history"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Riwayat Kunjungan</h6>
                                <small class="text-muted">Lihat riwayat pemeriksaan</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="#" class="menu-item">
                            <div class="menu-icon">
                                <i class="fas fa-file-medical"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Rekam Medis</h6>
                                <small class="text-muted">Lihat catatan kesehatan hewan</small>
                            </div>
                        </a>
                        <a href="#" class="menu-item">
                            <div class="menu-icon">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Pembayaran</h6>
                                <small class="text-muted">Kelola tagihan dan pembayaran</small>
                            </div>
                        </a>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="menu-item">
                            <div class="menu-icon">
                                <i class="fas fa-sign-out-alt"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Logout</h6>
                                <small class="text-muted">Keluar dari sistem</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
