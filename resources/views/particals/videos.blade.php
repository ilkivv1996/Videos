@extends('welcome')

    @section('title')
       Список видео
    @endsection

    @section('content')
        <a href="/">На главную</a>
        @foreach($video as $item)
        <h5>{{ $item->title }}</h5>
            <a href="videos/{{$item->link}}">Смотреть видео</a>
        @endforeach
    @endsection