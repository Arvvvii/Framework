@extends('layouts.pemilik.main')

@section('title', 'Pet Saya')

@section('content')
<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Pet Saya</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('pemilik.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pet Saya</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="app-content">
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Profil Pemilik</h3>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-2">Nama</dt>
                            <dd class="col-sm-4">{{ optional(optional($pemilik)->user)->nama ?? '-' }}</dd>
                            <dt class="col-sm-2">Email</dt>
                            <dd class="col-sm-4">{{ optional(optional($pemilik)->user)->email ?? '-' }}</dd>

                            <dt class="col-sm-2">Telepon</dt>
                            <dd class="col-sm-4">{{ optional($pemilik)->no_wa ?? '-' }}</dd>
                            <dt class="col-sm-2">Alamat</dt>
                            <dd class="col-sm-4">{{ optional($pemilik)->alamat ?? '-' }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Pet</h3>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <table id="petTable" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Umur</th>
                                    <th>Warna/Tanda</th>
                                    <th>Ras Hewan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pets as $pet)
                                    <tr>
                                        <td>{{ $pet->idpet }}</td>
                                        <td>{{ $pet->nama }}</td>
                                        <td>
                                            @if($pet->jenis_kelamin == 'M')
                                                <span class="badge bg-primary">Jantan</span>
                                            @else
                                                <span class="badge bg-danger">Betina</span>
                                            @endif
                                        </td>
                                        <td>{{ $pet->tanggal_lahir ? $pet->tanggal_lahir->format('d-m-Y') : 'N/A' }}</td>
                                        <td>{{ $pet->tanggal_lahir ? $pet->tanggal_lahir->diffForHumans(['parts' => 2]) : 'N/A' }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($pet->warna_tanda ?? 'N/A', 30) }}</td>
                                        <td>{{ $pet->rasHewan->nama_ras ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data pet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        @if($pets->count() > 0)
        $('#petTable').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            pageLength: 25
        });
        @endif
    });
</script>
@endpush
