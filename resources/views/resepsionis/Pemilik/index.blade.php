@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pemilik</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pemilik as $p)
                <tr>
                    <td>{{ $p->idpemilik }}</td>
                    {{-- Nama dan Email datang dari relasi DataUser (user) --}}
                    <td>{{ $p->user->nama ?? '-' }}</td>
                    <td>{{ $p->alamat }}</td>
                    {{-- Telepon/WA disimpan di kolom no_wa pada tabel pemilik menurut model --}}
                    <td>{{ $p->no_wa ?? '-' }}</td>
                    <td>{{ $p->user->email ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No pemilik found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
