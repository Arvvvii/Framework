@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pet Management</h1>

    <div class="mb-3">
        <a href="{{ route('admin.pet.create') }}" class="btn btn-primary">Tambah Pet</a>
    </div>
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
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pets as $pet)
                <tr>
                    <td>{{ $pet->idpet }}</td>
                    <td>{{ $pet->nama }}</td>
                    <td>{{ optional($pet->tanggal_lahir)->format('d-m-Y') ?? 'N/A' }}</td>
                    <td>{{ $pet->warna_tanda }}</td>
                    <td>{{ $pet->jenis_kelamin }}</td>
                    <td>{{ optional($pet->pemilik->user)->nama ?? 'N/A' }}</td>
                    <td>{{ optional($pet->rasHewan)->nama_ras ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('admin.pet.edit', $pet) }}" class="btn btn-sm btn-secondary">Edit</a>

                        <form action="{{ route('admin.pet.destroy', $pet) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus pet ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
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
