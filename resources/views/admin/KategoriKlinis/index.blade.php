@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Kategori Klinis Management</h1>
    <div class="mb-3">
        <a href="{{ route('admin.kategoriklinis.create') }}" class="btn btn-primary">Tambah Kategori Klinis</a>
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
                <th>Nama Kategori Klinis</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategorikliniss as $kk)
                <tr>
                    <td>{{ $kk->idkategori_klinis }}</td>
                    <td>{{ $kk->nama_kategori_klinis }}</td>
                    <td>
                        <a href="{{ route('admin.kategoriklinis.edit', $kk) }}" class="btn btn-sm btn-secondary">Edit</a>

                        <form action="{{ route('admin.kategoriklinis.destroy', $kk) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus kategori klinis ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No kategori klinis found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
