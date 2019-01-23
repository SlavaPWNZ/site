<div class="container box">
    <h1 align="center">Текущая страница -> {{$title_editor}}</h1>
    <br/>
    <div align="right">
        <button type="button" id="modal_button" class="btn btn-info">Создать пункт меню</button>
    </div>
    <br />

    <div id="result" class="table-responsive">
     @if (count($result))
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Адрес</th>
                <th>ID родителя</th>
                <th>Обновить</th>
                <th>Удалить</th>
            </tr>

            @foreach ($result as $row)
            <tr>
                <td>{{$row["id"]}}</td>
                <td>{{$row["title"]}}</td>
                <td>{{$row["path"]}}</td>
                <td>{{$row["parent_id"]}}</td>
                <td><button type="button" id="{{$row["id"]}}" class="btn btn-warning btn-xs update">Обновить</button></td>
                <td><button type="button" id="{{$row["id"]}}" class="btn btn-danger btn-xs delete">Удалить</button></td>
            </tr>
            @endforeach
            </table>
     @else
        <h3>Данных нет</h3>
     @endif
     </div>
</div>