@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <h1 class="display-4">Dashboard Perawat</h1>
            <p class="lead">You are logged in as {{ session('user_role_name') ?? 'Perawat' }}</p>

            <h2 class="mt-4">Daftar Isi</h2>
            <ul>
                <li><a href="{{ route('perawat.rekammedis.index') }}">Rekam Medis</a></li>
                <li><a href="{{ route('perawat.tindakanterapi.index') }}">Tindakan Terapi</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection
