@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Role</h1>

    <form action="{{ route('role.update', $role) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama_role">Nama Role</label>
            <input type="text" class="form-control" id="nama_role" name="nama_role" value="{{ old('nama_role', $role->nama_role) }}" required>
            @error('nama_role')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Role</button>
        <a href="{{ route('role.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
