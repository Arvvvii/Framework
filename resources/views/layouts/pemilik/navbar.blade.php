<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <!-- Start navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="{{ route('pemilik.dashboard') }}" class="nav-link">Home</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ms-auto">
            <!-- User Menu -->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fas fa-user-circle fa-lg"></i>
                    <span class="d-none d-md-inline">{{ session('user_name', 'Pemilik') }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header bg-success text-white">
                        <i class="fas fa-user-circle fa-3x"></i>
                        <p>
                            {{ session('user_name', 'Pemilik') }}
                            <small>Pemilik Pet</small>
                        </p>
                    </li>
                    <li class="user-footer">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-default btn-flat float-end">Sign out</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
