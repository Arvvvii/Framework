@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Kategori Klinis Management</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Kategori Klinis</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategorikliniss as $kk)
                <tr>
                    <td>{{ $kk->idkategori_klinis }}</td>
                    <td>{{ $kk->nama_kategori_klinis }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No kategori klinis found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
