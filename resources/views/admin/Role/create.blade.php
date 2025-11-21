@extends('layouts.admin.main')

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
{{-- create view only; role listing removed from this file to avoid undefined $roles --}}