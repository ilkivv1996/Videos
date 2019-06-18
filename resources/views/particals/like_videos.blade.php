
@foreach($random as $item)
        <h5>{{ $item->title }}</h5>
        <img src="{{$item->img}}">
        <a href="{{$item->path_url}}">Смотреть видео</a>
@endforeach