@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Kode Tindakan Terapi Management</h1>
    <div class="mb-3">
        <a href="{{ route('admin.kodeterapi.create') }}" class="btn btn-primary">Tambah Kode Terapi</a>
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
                <th>Kode</th>
                <th>Deskripsi</th>
                <th>Kategori</th>
                <th>Kategori Klinis</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kodeterapis as $kt)
                <tr>
                    <td>{{ $kt->idkode_tindakan_terapi }}</td>
                    <td>{{ $kt->kode }}</td>
                    <td>{{ $kt->deskripsi_tindakan_terapi }}</td>
                    <td>{{ $kt->kategori->nama_kategori ?? 'N/A' }}</td>
                    <td>{{ $kt->kategoriKlinis->nama_kategori_klinis ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('admin.kodeterapi.edit', $kt) }}" class="btn btn-sm btn-secondary">Edit</a>

                        <form action="{{ route('admin.kodeterapi.destroy', $kt) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus kode terapi ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No kode tindakan terapi found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
