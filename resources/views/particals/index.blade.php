@extends('welcome')

@section('title')
    Главная
@endsection

@section('content')
    Главная</br>
    <h3>Рандомные видео</h3>
    @foreach($videos as $video)
        <h6>{{ $video->title }}</h6>
        <img src="{{$video->img}}"></br>
        <a href="{{$video->path_url}}">Смотреть видео</a>
    @endforeach
@endsection