<!DOCTYPE html>
<html>
<head>
    <meta name="_token" content="{{csrf_token()}}" />
    <title>Menu</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4 mx-auto">
                    <div id="jquery-accordion-menu" class="jquery-accordion-menu black"></div>
                </div>
            </div>
        </div>

        <div id="result"></div>
</body>


<!-- Модальное окно которое будем использовать для добавления или изменения информации, в данный момент скрыто!-->
<div id="customerModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Создать пункт меню</h4>
            </div>
            <div class="modal-body">
                <label>Введите название</label>
                <input type="text" name="title" id="title" class="form-control"/>
                <br />
                <label>Введите ссылку</label>
                <input type="text" name="path" id="path" class="form-control"/>
                <br />
                <label>Введите id родителя</label>
                <select name="parent_id" id="parent_id" class="form-control" required>
                <?php foreach ($parentsID as $parentID) {
                    echo '<option>'.$parentID['parent_id'].'</option>';
                }?>
                </select>
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
<script src="js/jquery-1.11.3.min.js"></script>

<script src="js/vam.md.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script type="text/javascript" src="js/script.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</html>
