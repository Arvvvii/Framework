@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard Pemilik</h1>
    <p>You are logged in as Pemilik</p>

    <h2>Daftar Isi</h2>
    <ul>
        <li><a href="{{ route('pemilik.pet.index') }}">Pet</a></li>
    <li><a href="{{ route('pemilik.rekammedis.index') }}">Rekam Medis</a></li>
    </ul>
</div>
@endsection
