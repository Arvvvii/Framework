@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Kategori Klinis</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.kategoriklinis.update', $kategoriklinis) }}" method="post">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_kategori_klinis" class="form-label">Nama Kategori Klinis</label>
            <input type="text" name="nama_kategori_klinis" id="nama_kategori_klinis" value="{{ old('nama_kategori_klinis', $kategoriklinis->nama_kategori_klinis) }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="{{ route('admin.kategoriklinis.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
