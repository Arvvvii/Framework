<!DOCTYPE HTML>
<html lang="en">  

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSHP UNAIR - Universitas Airlangga</title> 
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    </head>

<body>
    <header class="official-header-wrapper">
        <nav class="top-nav">
            <div class="container">
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('struktur-organisasi') }}">Struktur Organisasi</a></li>
                    <li><a href="{{ route('layanan-umum') }}">Layanan Umum</a></li>
                    <li><a href="{{ route('visi-misi-tujuan') }}">Visi Misi dan Tujuan</a></li>
                    <li><a href="{{ route('berita') }}">Berita</a></li>
                    <li><a href="{{ route('login') }}">Login</a></li>
                </ul>
            </div>
        </nav>
        <div class="logo-bar">
            <div class="container">
                <img src="{{ asset('https://rshp.unair.ac.id/wp-content/uploads/2024/06/UNIVERSITAS-AIRLANGGA-scaled.webp') }}" alt="Logo Universitas Airlangga" class="logo-unair">
            </div>
        </div>
    </header>

    <main>
        @yield('content') 
    </main>

    <footer class="app-footer">
        <div class="footer-title">
            Rumah Sakit Hewan Pendidikan Universitas Airlangga
        </div>
        <div class="footer-text">
            Bersama RSHP UNAIR, wujudkan kesehatan hewan yang lebih baik untuk masa depan yang cerah.
        </div>
        <div class="footer-copy">
            © {{ date('Y') }} Rumah Sakit Hewan Pendidikan Universitas Airlangga. All rights reserved.
        </div>
    </footer>
</body>
</html>