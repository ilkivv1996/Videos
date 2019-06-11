<form action="{{route('search')}}" method="post">
    @csrf
    <input name="search" type="text" placeholder="Поиск">

    <input type='submit' value='Отправить'>

</form>