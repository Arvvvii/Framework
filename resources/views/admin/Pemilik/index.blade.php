@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pemilik Management</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>No WA</th>
                <th>Alamat</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pemilik as $p)
                <tr>
                    <td>{{ $p->idpemilik }}</td>
                    <td>{{ $p->no_wa }}</td>
                    <td>{{ $p->alamat }}</td>
                    <td>{{ $p->user->nama ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No pemilik found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
