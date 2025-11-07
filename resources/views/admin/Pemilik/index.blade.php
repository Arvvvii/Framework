@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pemilik Management</h1>

    <div class="mb-3">
        <a href="{{ route('admin.pemilik.create') }}" class="btn btn-primary">Tambah Pemilik</a>
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
                <th>No WA</th>
                <th>Alamat</th>
                <th>User</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pemiliks as $p)
                <tr>
                    <td>{{ $p->idpemilik }}</td>
                    <td>{{ $p->no_wa }}</td>
                    <td>{{ $p->alamat }}</td>
                    <td>{{ $p->user->nama ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('admin.pemilik.edit', $p) }}" class="btn btn-sm btn-secondary">Edit</a>

                        <form action="{{ route('admin.pemilik.destroy', $p) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus pemilik ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No pemilik found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
