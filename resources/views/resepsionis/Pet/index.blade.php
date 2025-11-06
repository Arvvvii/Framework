@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pet</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
                <th>Pemilik</th>
                <th>Ras Hewan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pets as $pet)
                <tr>
                    <td>{{ $pet->idpet }}</td>
                    <td>{{ $pet->nama }}</td>
                    <td>{{ $pet->jenis_kelamin }}</td>
                    <td>{{ $pet->tanggal_lahir ? $pet->tanggal_lahir->format('d-m-Y') : 'N/A' }}</td>
                    <td>{{ optional($pet->pemilik->user)->nama ?? 'N/A' }}</td>
                    <td>{{ optional($pet->rasHewan)->nama_ras ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No pets found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
