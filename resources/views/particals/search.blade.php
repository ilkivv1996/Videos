<form action="{{route('search')}}" method="post">
    <div class="form-group">
        @csrf
        <input name="search" type="text" placeholder="Поиск" width="100%" height="100%">
        <input type='submit' value='Отправить'>
    </div>
</form>
