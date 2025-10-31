@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Rekam Medis</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Anamnesa</th>
                <th>Temuan Klinis</th>
                <th>Diagnosa</th>
                <th>Dokter Pemeriksa</th>
                <th>Nama Hewan</th>
                <th>Pemilik</th>
                <th>Ras Hewan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekamMedis as $rm)
                <tr>
                    <td>{{ $rm->idrekam_medis }}</td>
                    <td>{{ $rm->created_at ? $rm->created_at->format('d-m-Y') : 'N/A' }}</td>
                    <td>{{ $rm->anamnesa }}</td>
                    <td>{{ $rm->temuan_klinis }}</td>
                    <td>{{ $rm->diagnosa }}</td>
                    <td>{{ $rm->roleUser->user->nama ?? 'N/A' }}</td>
                    <td>{{ $rm->temuDokter->pet->nama ?? 'N/A' }}</td>
                    <td>{{ $rm->temuDokter->pet->pemilik->nama ?? 'N/A' }}</td>
                    <td>{{ $rm->temuDokter->pet->rasHewan->nama_ras ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">No rekam medis found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
