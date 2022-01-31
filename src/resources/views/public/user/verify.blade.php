@extends('public.layout')

@section('content')

@isset($error)
{{ $error }}
@endisset

@isset($message)
{{ $message }}
@endisset

@endsection
