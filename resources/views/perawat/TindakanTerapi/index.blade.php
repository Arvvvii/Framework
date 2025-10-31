@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Kode Tindakan Terapi Management</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Kode Tindakan Terapi</th>
                <th>Kode</th>
                <th>Deskripsi Tindakan Terapi</th>
                <th>Kategori</th>
                <th>Kategori Klinis</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kodeTindakanTerapis as $kode)
                <tr>
                    <td>{{ $kode->idkode_tindakan_terapi }}</td>
                    <td>{{ $kode->kode }}</td>
                    <td>{{ $kode->deskripsi_tindakan_terapi }}</td>
                    <td>{{ $kode->kategori->nama_kategori ?? 'N/A' }}</td>
                    <td>{{ $kode->kategoriKlinis->nama_kategori_klinis ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No kode tindakan terapi found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
