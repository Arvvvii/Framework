@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Temu Dokter</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Keluhan</th>
                <th>Nama Hewan</th>
                <th>Pemilik</th>
                <th>Ras Hewan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($temuDokter as $td)
                <tr>
                    <td>{{ $td->idtemu_dokter }}</td>
                    <td>{{ $td->tanggal ? $td->tanggal->format('d-m-Y') : 'N/A' }}</td>
                    <td>{{ $td->keluhan }}</td>
                    <td>{{ $td->pet->nama ?? 'N/A' }}</td>
                    <td>{{ $td->pet->pemilik->nama ?? 'N/A' }}</td>
                    <td>{{ $td->pet->rasHewan->nama_ras ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No temu dokter found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
