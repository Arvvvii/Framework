@extends('layouts.admin.main')

@section('content')
<div class="container">
    <h1>Tambah Kategori Klinis</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Use the resource store route for creating a new Kategori Klinis --}}
    <form action="{{ route('admin.kategoriklinis.store') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="nama_kategori_klinis" class="form-label">Nama Kategori Klinis</label>
            <input type="text" name="nama_kategori_klinis" id="nama_kategori_klinis" value="{{ old('nama_kategori_klinis') }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.kategoriklinis.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
