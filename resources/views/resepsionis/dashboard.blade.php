@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard Resepsionis</h1>
    <p>You are logged in as Resepsionis</p>

    <h2>Daftar Isi</h2>
    <ul>
        <li><a href="{{ route('resepsionis.pemilik.index') }}">Pemilik</a></li>
        <li><a href="{{ route('resepsionis.pet.index') }}">Pet</a></li>
        <li><a href="{{ route('resepsionis.temudokter.index') }}">Temu Dokter</a></li>
    </ul>
</div>
@endsection
