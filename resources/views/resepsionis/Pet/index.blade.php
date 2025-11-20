@extends('layouts.resepsionis.main')

@section('title', 'Pet')

@section('content')
<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Pet</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('resepsionis.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pet</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Pet</h3>
                        <div class="card-tools">
                            <a href="{{ route('resepsionis.pet.create') }}" class="btn btn-success btn-sm">
                                <i class="fas fa-plus"></i> Tambah Pet
                            </a>
                        </div>
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
                                    <th>Pemilik</th>
                                    <th>Ras Hewan</th>
                                    <th>Aksi</th>
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
                                        <td>{{ $pet->pemilik->user->nama ?? 'N/A' }}</td>
                                        <td>{{ $pet->rasHewan->nama_ras ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('resepsionis.pet.edit', $pet->idpet) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('resepsionis.pet.destroy', $pet->idpet) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus pet ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Tidak ada data pet.</td>
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
        $('#petTable').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            pageLength: 25
        });
    });
</script>
@endpush
