
    <nav>
        <ul>
            <li><a href="/">Главная</a></li>
            @foreach($menu as $item)
                <li><a href="/videos/{{ $item->url }}">{!! $item->title!!}</a></li>
            @endforeach
        </ul>
    </nav>

