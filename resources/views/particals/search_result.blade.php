@extends('welcome')

@section('title')
    Поиск - Результаты
@endsection

@section('content')
    <row>
        @if(!isset($search))
            <p>Нет результатов</p>
        @else
            @foreach($search as $item)
                <h5>{{ $item->title }}</h5>
                <img src="{{$item->img}}"></br>
                <a href="{{$item->path_url}}">Смотреть видео</a>
            @endforeach
        @endif
    </row>

@endsection
