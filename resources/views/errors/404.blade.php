@extends('errors::minimal')

@section('title', 'Nie znaleziono')
@section('code', '404')
@section('message')
    {{ $exception?->getMessage() ?: 'Nie znaleziono strony.' }}
@endsection
