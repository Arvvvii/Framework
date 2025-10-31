@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard Administrator</h1>
    <p>You are logged in as Administrator</p>

    <h2>Daftar Isi</h2>
    <ul>
        <li><a href="{{ route('admin.role.index') }}">Role</a></li>
        <li><a href="{{ route('admin.datauser.index') }}">Data User</a></li>
        <li><a href="{{ route('admin.pet.index') }}">Pet</a></li>
        <li><a href="{{ route('admin.pemilik.index') }}">Pemilik</a></li>
        <li><a href="{{ route('admin.kategoriklinis.index') }}">Kategori Klinis</a></li>
        <li><a href="{{ route('admin.kodeterapi.index') }}">Kode Terapi</a></li>
        <li><a href="{{ route('admin.kategori.index') }}">Kategori</a></li>
        <li><a href="{{ route('admin.jenishewan.index') }}">Jenis Hewan</a></li>
        <li><a href="{{ route('admin.rashewan.index') }}">Ras Hewan</a></li>
        <li><a href="{{ route('admin.rekammedis.index') }}">Rekam Medis</a></li>
    </ul>
</div>
@endsection
