@foreach($random as $item)
    <h5>{{ $item->title }}</h5>
    <a href="{{$item->link}}">Смотреть видео</a>
@endforeach