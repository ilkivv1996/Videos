@extends('welcome')

@section('title')
    Список видео
@endsection

@section('content')
    <a href="/">На главную</a>
    @if(!isset($videos))
   <p>К сожалению ничего не найдено</p>
    @else
        @foreach($videos as $item)
            <h5>{{ $item->title }}</h5>
            <img src="{{$item->img}}"></br>
            <a href="{{$item->path_url}}">Смотреть видео</a>
        @endforeach
    @endif
@endsection