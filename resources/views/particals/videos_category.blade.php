@extends('welcome')

@section('title')
    Список видео
@endsection

@section('content')
    <a href="/">На главную</a>
    @foreach($videos as $item)
        <h5>{{ $item->title }}</h5>
        <img src="{{$item->img}}"></br>
        <a href="{{$category->url}}/{{$item->link}}">Смотреть видео</a>
    @endforeach
@endsection