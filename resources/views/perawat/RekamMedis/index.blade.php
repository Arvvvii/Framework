@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Rekam Medis Management</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Rekam Medis</th>
                <th>Tanggal Dibuat</th>
                <th>Anamnesa</th>
                <th>Temuan Klinis</th>
                <th>Diagnosa</th>
                <th>Dokter Pemeriksa</th>
                <th>Nama Pet</th>
                <th>Pemilik Pet</th>
                <th>Ras Hewan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekamMedis as $rekam)
                <tr>
                    <td>{{ $rekam->idrekam_medis }}</td>
                    <td>
                        {{ $rekam->created_at?->format('d-m-Y H:i:s') ?? 'N/A' }}<br>
                        <small>{{ $rekam->created_at?->diffForHumans() }}</small>
                    </td>
                    <td>{{ $rekam->anamnesa }}</td>
                    <td>{{ $rekam->temuan_klinis }}</td>
                    <td>{{ $rekam->diagnosa }}</td>
                    <td>{{ $rekam->roleUser->user->nama ?? 'N/A' }}</td>
                    <td>{{ $rekam->temuDokter->pet->nama ?? 'N/A' }}</td>
                    <td>{{ optional($rekam->temuDokter->pet->pemilik->user)->nama ?? 'N/A' }}</td>
                    <td>{{ optional($rekam->temuDokter->pet->rasHewan)->nama_ras ?? 'N/A' }}</td>
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
