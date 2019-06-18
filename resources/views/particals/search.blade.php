<div class="row">
    <form action="{{route('search')}}" method="post">
        @csrf
        <input name="search" type="text" placeholder="Поиск" width="100%" height="100%">
        <input type='submit' value='Отправить'>
    </form>
</div>
