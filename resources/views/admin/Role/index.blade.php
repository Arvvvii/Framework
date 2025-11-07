@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Role Management</h1>
    <div class="mb-3">
        <a href="{{ route('admin.role.create') }}" class="btn btn-primary">Tambah Role</a>
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
                <th>Nama Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($roles as $role)
                <tr>
                    <td>{{ $role->idrole }}</td>
                    <td>{{ $role->nama_role }}</td>
                    <td>
                        <a href="{{ route('admin.role.edit', $role) }}" class="btn btn-sm btn-secondary">Edit</a>

                        <form action="{{ route('admin.role.destroy', $role) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus role ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No roles found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
