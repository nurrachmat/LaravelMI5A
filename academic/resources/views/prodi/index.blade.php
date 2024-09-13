@extends('layouts.main')

@section('content')
    @foreach ($prodi as $row)
        {{ $row['nama'] }}
    @endforeach
@endsection