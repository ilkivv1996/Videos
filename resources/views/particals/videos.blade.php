@extends('welcome')

    @section('title')
       Список видео
    @endsection

    @section('content')
        <a href="/">На главную</a>
        @if(!isset($search))
            <p>Нет результатов</p>
        @else
            @foreach($search as $item)
                <h5>{{ $item->title }}</h5>
                <img src="{{$item->img}}">
                <a href="{{$item->link}}">Смотреть видео</a>
            @endforeach
        @endif

    @endsection