@extends('layouts.main')

@section('content')
<h4>Program Studi</h4>
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Nama Prodi</th>
            <th>Kaprodi</th>
            <th>Singkatan</th>
            <th>Fakultas</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($prodi as $row)
            <tr>
                <td>{{ $row['nama'] }}</td>
                <td>{{ $row['kaprodi'] }}</td>
                <td>{{ $row['singkatan'] }}</td>
                <td>{{ $row['fakultas']['nama'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection