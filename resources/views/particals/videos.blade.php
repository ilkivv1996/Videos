@extends('welcome')

    @section('title')
       Список видео
    @endsection

    @section('content')
        @if(!isset($search))
            <p>Нет результатов</p>
        @else
            <div class="col-lg-6 col-md-6">
                @foreach($search as $item)
                    <h5>{{ $item->title }}</h5>
                    <img src="{{$item->img}}">
                    <a href="{{$item->link}}">Смотреть видео</a>
                @endforeach
            </div>
        @endif
    @endsection