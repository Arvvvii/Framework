@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pet Management</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Tanggal Lahir</th>
                <th>Warna Tanda</th>
                <th>Jenis Kelamin</th>
                <th>Pemilik</th>
                <th>Ras Hewan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pets as $pet)
                <tr>
                    <td>{{ $pet->idpet }}</td>
                    <td>{{ $pet->nama }}</td>
                    <td>{{ $pet->tanggal_lahir->format('d-m-Y') }}</td>
                    <td>{{ $pet->warna_tanda }}</td>
                    <td>{{ $pet->jenis_kelamin }}</td>
                    <td>{{ $pet->pemilik->nama ?? 'N/A' }}</td>
                    <td>{{ $pet->rasHewan->nama_ras_hewan ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No pets found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
