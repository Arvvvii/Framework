@extends('layouts.admin.main')

@section('content')
<div class="container">
    <h1>Role Details</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Role Information</h5>
            <p><strong>ID:</strong> {{ $role->idrole }}</p>
            <p><strong>Nama Role:</strong> {{ $role->nama_role }}</p>
        </div>
    </div>

    <a href="{{ route('role.index') }}" class="btn btn-secondary mt-3">Back to List</a>
</div>
@endsection
