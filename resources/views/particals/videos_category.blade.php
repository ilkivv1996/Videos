
@extends('welcome')


@section('link')
    <link rel="stylesheet" href="/css/videos_category.css">
@endsection

@section('title')
    Список видео
@endsection

@section('content')
    @if(!isset($videos))
        <p>К сожалению ничего не найдено</p>
    @else
        <div class="card-group ">
            @foreach($videos as $item)
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 custom-block d-flex align-items-stretch">
                    <div class="card card-cascade custom-card text-center">
                        <a href="{{$item->path_url}}"><img class="card-img-top" src="{{$item->img}}" alt="{{ $item->title }}"></a>
                        <div class="card-body">
                            <p class="card-text">{{ $item->title }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
