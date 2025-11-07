@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ras Hewan Management</h1>

    <div class="mb-3">
        <a href="{{ route('admin.rashewan.create') }}" class="btn btn-primary">Tambah Ras Hewan</a>
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
                <th>Nama Ras</th>
                <th>Jenis Hewan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rashewans as $rh)
                <tr>
                    <td>{{ $rh->idras_hewan }}</td>
                    <td>{{ $rh->nama_ras }}</td>
                    <td>{{ $rh->jenisHewan->nama_jenis_hewan ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('admin.rashewan.edit', $rh) }}" class="btn btn-sm btn-secondary">Edit</a>

                        <form action="{{ route('admin.rashewan.destroy', $rh) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus ras hewan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
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
