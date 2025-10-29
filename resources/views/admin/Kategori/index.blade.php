@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Kategori Management</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Kategori</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategoris as $kat)
                <tr>
                    <td>{{ $kat->idkategori }}</td>
                    <td>{{ $kat->nama_kategori }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No kategori found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
