@extends('layouts.admin.main')

@section('content')
<div class="container">
    <h1>Edit Role</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.role.update', optional($role)->idrole) }}" method="post">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_role" class="form-label">Nama Role</label>
            <input type="text" name="nama_role" id="nama_role" value="{{ old('nama_role', $role->nama_role) }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="{{ route('admin.role.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
@extends('layouts.admin.main')

@section('content')
<div class="container">
    <h1>Edit Role</h1>

    <form action="{{ route('admin.role.update', optional($role)->idrole) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama_role">Nama Role</label>
            <input type="text" class="form-control" id="nama_role" name="nama_role" value="{{ old('nama_role', optional($role)->nama_role) }}" required>
            @error('nama_role')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Role</button>
        <a href="{{ route('admin.role.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
