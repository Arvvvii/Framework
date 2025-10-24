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