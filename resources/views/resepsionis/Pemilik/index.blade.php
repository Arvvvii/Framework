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
                    <td>{{ $p->nama }}</td>
                    <td>{{ $p->alamat }}</td>
                    <td>{{ $p->telepon }}</td>
                    <td>{{ $p->email }}</td>
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
