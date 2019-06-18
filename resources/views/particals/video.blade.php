@extends('welcome')

@section('title')
    {{$video->title}}
@endsection

@section('content')
    <row>
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <a href="/videos/{{$url1}}">Вернуться к списку видео</a>
            <h3>{{$video->title}}</h3>
            <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{$video->video}}" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            @include('particals.like_videos')
        </div>
    </row>

@endsection
