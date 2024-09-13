@extends('layouts.main')

@section('content')
    @foreach ($fakultas as $row)
        {{ $row['nama'] }}
    @endforeach
@endsection