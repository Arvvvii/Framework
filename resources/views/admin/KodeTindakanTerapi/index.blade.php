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
                <th>ID</th>
                <th>Kode</th>
                <th>Deskripsi</th>
                <th>Kategori</th>
                <th>Kategori Klinis</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kodeterapis as $kt)
                <tr>
                    <td>{{ $kt->idkode_tindakan_terapi }}</td>
                    <td>{{ $kt->kode }}</td>
                    <td>{{ $kt->deskripsi_tindakan_terapi }}</td>
                    <td>{{ $kt->kategori->nama_kategori ?? 'N/A' }}</td>
                    <td>{{ $kt->kategoriKlinis->nama_kategori_klinis ?? 'N/A' }}</td>
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
