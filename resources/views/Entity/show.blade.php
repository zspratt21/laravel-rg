@extends('base')
@section('title')
    View the entity
@endsection
@section('content')
{{$name}}
{{$description}}

<img src="{{$logo}}">
@endsection
