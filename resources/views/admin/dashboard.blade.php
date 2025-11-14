@extends('layouts.admin.main')

@section('title', 'Dashboard Administrator')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Dashboard</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        
        <!-- Statistics Cards -->
        <div class="row g-3 mb-4">
            <!-- Total Users -->
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="bi bi-people text-white" style="font-size: 1.5rem;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h2 class="mb-0 fw-bold">{{ $stats['total_users'] ?? 0 }}</h2>
                            <p class="text-muted mb-0 small">Total Users</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Registered Pets -->
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="bi bi-heart text-white" style="font-size: 1.5rem;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h2 class="mb-0 fw-bold">{{ $stats['total_pets'] ?? 0 }}</h2>
                            <p class="text-muted mb-0 small">Registered Pets</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Appointments -->
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="bi bi-calendar-check text-white" style="font-size: 1.5rem;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h2 class="mb-0 fw-bold">{{ $stats['total_pemilik'] ?? 0 }}</h2>
                            <p class="text-muted mb-0 small">Pemilik Terdaftar</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medical Records -->
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="bi bi-file-earmark-medical text-white" style="font-size: 1.5rem;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h2 class="mb-0 fw-bold">{{ $stats['total_kode_terapi'] ?? 0 }}</h2>
                            <p class="text-muted mb-0 small">Medical Records</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Overview & Quick Actions -->
        <div class="row g-3 mb-4">
            <!-- Activity Overview Chart -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Activity Overview</h5>
                        <span class="badge bg-light text-dark">Last 6 months</span>
                    </div>
                    <div class="card-body">
                        <canvas id="activityChart" height="80"></canvas>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.datauser.create') }}" class="btn btn-outline-primary text-start">
                                <i class="bi bi-person-plus me-2"></i> Tambah User
                            </a>
                            <a href="{{ route('admin.pet.create') }}" class="btn btn-outline-success text-start">
                                <i class="bi bi-heart-fill me-2"></i> Tambah Pet
                            </a>
                            <a href="#" class="btn btn-outline-warning text-start">
                                <i class="bi bi-calendar-plus me-2"></i> Tambah Tindakan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="row g-3">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">Recent Users</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Joined</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recent_users ?? [] as $user)
                                    <tr>
                                        <td class="fw-semibold">{{ $user->nama }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td><span class="badge bg-light text-dark">{{ \Carbon\Carbon::parse($user->created_at ?? now())->format('d M Y') }}</span></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">No recent users</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@push('head')
<style>
.card {
    transition: all 0.3s ease;
}
.card:hover {
    transform: translateY(-2px);
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('activityChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Visits',
                    data: [120, 150, 140, 180, 200, 220],
                    borderColor: 'rgb(54, 162, 235)',
                    backgroundColor: 'rgba(54, 162, 235, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'New Users',
                    data: [30, 50, 40, 45, 60, 80],
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush
@endsection
