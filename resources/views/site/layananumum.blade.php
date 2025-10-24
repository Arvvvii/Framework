@extends('layouts.app')

@section('content')

    <section class="content-wrapper">
        <div class="org-section-wrapper">
            <h2 class="section-title" style="font-size: 1.3em; margin-bottom: 28px;">
                Layanan Umum
            </h2>
            <div class="service-list">
                <div class="service-card">
                    <img src="https://i.pinimg.com/736x/2e/27/46/2e27468b8ba113252ad31bd53e60f8da.jpg" alt="Rawat Inap" class="service-img">
                    <div class="service-title">Instalansi Rawat Inap</div>
                </div>
                <div class="service-card">
                    <img src="https://img.icons8.com/color/96/pills.png" alt="Farmasi" style="width: 56px; height: 56px;" class="service-img">
                    <div class="service-title">Farmasi</div>
                </div>
                <div class="service-card">
                    <img src="https://img.icons8.com/color/96/stethoscope.png" alt="Rawat Jalan" style="width: 56px; height: 56px;" class="service-img">
                    <div class="service-title">Rawat Jalan</div>
                </div>
                <div class="service-card">
                    <img src="https://img.icons8.com/color/96/surgery.png" alt="Bedah" style="width: 56px; height: 56px;" class="service-img">
                    <div class="service-title">Bedah</div>
                </div>
                <div class="service-card">
                    <img src="https://i.pinimg.com/736x/a4/bc/a6/a4bca6a2aaf40d6b837474660a4eb246.jpg" alt="Ultrasonografi" style="width: 56px; height: 56px;" class="service-img">
                    <div class="service-title">Ultrasonografi</div>
                </div>
            </div>
        </div>
    </section>

    <div class="location-wrapper">
        <div class="map-frame-box">
            <iframe src="https://www.google.com/maps?q=Rumah+Sakit+Hewan+Pendidikan+Universitas+Airlangga+Kampus+Merr+C&output=embed" width="450" height="350" style="border:0; border-radius: 8px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="address-card">
            <h3 class="address-title">Lokasi Rumah Sakit Hewan Pendidikan</h3>
            <div class="address-bold">
                Universitas Airlangga Kampus Merr C
            </div>
            <div class="address-text">
                Jl. Dharmahusada Permai, Mulyorejo, Kec. Mulyorejo, Surabaya, Jawa Timur 60115, Indonesia
            </div>
        </div>
    </div>

@endsection