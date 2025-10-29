@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ras Hewan Management</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Ras</th>
                <th>Jenis Hewan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rashewans as $rh)
                <tr>
                    <td>{{ $rh->idras_hewan }}</td>
                    <td>{{ $rh->nama_ras }}</td>
                    <td>{{ $rh->jenisHewan->nama_jenis_hewan ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No ras hewan found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
