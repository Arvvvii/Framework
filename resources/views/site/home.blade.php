@extends('layouts.app')

@section('content')

    <section class="content-wrapper"> 
        <div class="home-section">
            <div class="info-card">
                <h2 class="info-title">
                    Rumah Sakit Hewan Pendidikan Universitas Airlangga
                </h2>
                <p style="color: #333; font-size: 1em; margin-bottom: 24px;">
                    <span style="display: block; text-align: justify;">
                        Berinovasi untuk selalu meningkatkan kualitas pelayanan, maka dari itu Rumah Sakit Hewan Pendidikan Universitas Airlangga mempunyai fitur pendaftaran online yang mempermudah untuk mendaftarkan hewan kesayangan anda.
                    </span>
                </p>
                {{-- Guest notice removed --}}
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <button style="background: #60aee1; color: #fff; border: none; border-radius: 6px; padding: 12px 0; font-size: 1em; font-weight: bold; cursor: pointer;">
                        Selamat Datang
                    </button>
                </div>
                <button style="background: #97e58a; color: #005baa; border: none; border-radius: 6px; padding: 10px 0; font-size: 1em; font-weight: bold; cursor: pointer; margin-top: 24px; width: 100%;">
                    Informasi Jadwal Dokter Jaga
                </button>
            </div>

            <div style="background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); padding: 24px 28px; min-width: 380px;">
                <h3 style="color: #005baa; margin-top: 0; font-size: 1.1em; font-weight: bold; text-align: left;">
                    Video Profil RSHP UNAIR
                </h3>
                <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 8px;">
                    <iframe src="https://www.youtube.com/embed/rCfvZPECZvE?si=CsCvp2UwlwYtNwq3" title="Profil RSHP UNAIR" frameborder="0" allowfullscreen
                        style="position: absolute; top:0; left:0; width:100%; height:100%;"></iframe>
                </div>
            </div>
        </div>
    </section>

@endsection