@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Kategori Management</h1>
    <div class="mb-3">
        <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">Tambah Kategori</a>
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
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategoris as $kat)
                <tr>
                    <td>{{ $kat->idkategori }}</td>
                    <td>{{ $kat->nama_kategori }}</td>
                    <td>
                        <a href="{{ route('admin.kategori.edit', $kat) }}" class="btn btn-sm btn-secondary">Edit</a>

                        <form action="{{ route('admin.kategori.destroy', $kat) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No kategori found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
