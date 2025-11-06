@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Role</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.role.store') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="nama_role" class="form-label">Nama Role</label>
            <input type="text" name="nama_role" id="nama_role" value="{{ old('nama_role') }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.role.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
{{-- resources/views/admin/role/index.blade.php --}}

<h1>Daftar Role Pengguna</h1>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Role</th>
            <th>Keterangan</th> 
        </tr>
    </thead>
    <tbody>
        @foreach ($roles as $index => $item)
        <tr>
            <td>{{ $index + 1}}</td>
            {{-- Asumsi kolom di tabel role adalah 'nama_role' dan 'keterangan' --}}
            <td>{{ $item->nama_role }}</td> 
            <td>{{ $item->keterangan }}</td> 
        </tr>
        @endforeach
    </tbody>
</table>