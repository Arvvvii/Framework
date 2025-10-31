@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard Perawat</h1>
    <p>You are logged in as Perawat</p>

    <h2>Daftar Isi</h2>
    <ul>
        <li><a href="{{ route('perawat.rekammedis.index') }}">Rekam Medis</a></li>
        <li><a href="{{ route('perawat.tindakanterapi.index') }}">Tindakan Terapi</a></li>
    </ul>
</div>
@endsection
