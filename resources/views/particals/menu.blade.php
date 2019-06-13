<a href="/">Главная</a>
@foreach($menu as $item)
    <a href="/videos/{{ $item->url }}">{!! $item->title!!}</a>
@endforeach