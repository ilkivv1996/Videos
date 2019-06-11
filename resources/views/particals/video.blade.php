@extends('welcome')

@section('title')
    {{$video->title}}
@endsection

@section('content')
    <row>
        <div class="col-md-8">
            <a href="/{{$url1}}">Вернуться к списку видео</a>
            <H1>{{$video->title}}</H1>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/{{$video->video}}" frameborder="0" allowfullscreen>
            </iframe>
        </div>
        <div class="col-md-4"></div>
        @include('particals.like_videos')
    </row>

@endsection
