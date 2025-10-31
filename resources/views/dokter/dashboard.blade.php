@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard Dokter</h1>
    <p>You are logged in as Dokter</p>

    <h2>Daftar Isi</h2>
    <ul>
        <li><a href="{{ route('dokter.rekammedis.index') }}">Rekam Medis</a></li>
    </ul>
</div>
@endsection
