@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Data User Management</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @forelse($datausers as $datauser)
                <tr>
                    <td>{{ $datauser->iduser }}</td>
                    <td>{{ $datauser->nama }}</td>
                    <td>{{ $datauser->email }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No data users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
