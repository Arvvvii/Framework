@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Jenis Hewan Management</h1>
    <div class="mb-3">
        <a href="{{ route('admin.jenishewan.create') }}" class="btn btn-primary">Tambah Jenis Hewan</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Jenis Hewan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jenishawans as $jh)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $jh->nama_jenis_hewan }}</td>
                    <td>
                        <a href="{{ route('admin.jenishewan.edit', $jh) }}" class="btn btn-sm btn-secondary">Edit</a>

                        <form action="{{ route('admin.jenishewan.destroy', $jh) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No jenis hewan found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
