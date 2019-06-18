@extends('welcome')

@section('title')
    Главная
@endsection

@section('link')
    <link rel="stylesheet" href="css/index.css">
@endsection

@section('content')

    @foreach($videos as $video)
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="text_to_img">
                <a href="{{$video->path_url}}"><img  src="{{$video->img}}" class="example_beauty" title="{{ $video->title }}" height="100%"></a>
                <span>{{ $video->title }}</span>
            </div>
        </div>
    @endforeach
    </div>
@endsection

@section('script')

@endsection