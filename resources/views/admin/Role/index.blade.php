@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Role Management</h1>

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
            </tr>
        </thead>
        <tbody>
            @forelse($roles as $role)
                <tr>
                    <td>{{ $role->idrole }}</td>
                    <td>{{ $role->nama_role }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No roles found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
