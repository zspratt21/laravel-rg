@extends('base')
@section('title')
    View the entity
@endsection
@section('content')
{{$name}}
{{$description}}
<img src="http://192.168.186.227:8000{{$logo}}">
<img src="https://media.gettyimages.com/id/605856620/photo/elizabeth-quay-perth-western-australia-australia.jpg?s=612x612&w=gi&k=20&c=zKb6E9-F7k0AyR_-gbJTtQi6xEvkkZh35uWBK1scBig=">
{{--{{$logo}}--}}
@endsection
