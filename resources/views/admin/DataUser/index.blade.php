@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Data User Management</h1>
    <div class="mb-3">
        <a href="{{ route('admin.datauser.create') }}" class="btn btn-primary">Tambah Data User</a>
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
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($datausers as $datauser)
                <tr>
                    <td>{{ $datauser->iduser }}</td>
                    <td>{{ $datauser->nama }}</td>
                    <td>{{ $datauser->email }}</td>
                    <td>
                        <a href="{{ route('admin.datauser.edit', $datauser) }}" class="btn btn-sm btn-secondary">Edit</a>

                        <form action="{{ route('admin.datauser.destroy', $datauser) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data user ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No data users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
