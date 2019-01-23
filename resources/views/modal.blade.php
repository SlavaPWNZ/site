@section('modalform')
<!-- Модальное окно которое будем использовать для добавления или изменения информации, в данный момент скрыто!-->
    <div id="customerModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Создать пункт меню</h4>
                </div>
                <div class="modal-body">
                    <label>Введите название:</label>
                    <input type="text" name="title" id="title" class="form-control"/>
                    <br />
                    <label>Введите ссылку:</label>
                    <input type="text" name="path" id="path" class="form-control"/>
                    <br />
                    <label>Введите ID родителя:</label>
                    <select name="parent_id" id="parent_id" class="form-control" required></select>
                    <br />
                </div>
                <div class="alert alert-danger" style="display:none"></div>
                <div class="modal-footer">
                    <input type="hidden" name="menu_id" id="menu_id" />
                    <input type="submit" name="action" id="action" class="btn btn-success" value="Создать"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>
    </div>
@show
