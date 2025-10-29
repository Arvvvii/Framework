@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Jenis Hewan Management</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Jenis Hewan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jenishawans as $jh)
                <tr>
                    <td>{{ $jh->idjenis_hewan }}</td>
                    <td>{{ $jh->nama_jenis_hewan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No jenis hewan found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
