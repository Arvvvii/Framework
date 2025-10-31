@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Rekam Medis</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Anamnesa</th>
                <th>Temuan Klinis</th>
                <th>Diagnosa</th>
                <th>Dokter Pemeriksa</th>
                <th>Reservasi Dokter</th>
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
                    <td>{{ $rm->temuDokter->idreservasi_dokter ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No rekam medis found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
