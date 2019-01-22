<!DOCTYPE html>
<html>
<head>
    <meta name="_token" content="{{csrf_token()}}" />
    <title>Menu</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/styles.css" />
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/vam.md.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>
<body>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4 mx-auto">
                    <div id="jquery-accordion-menu" class="jquery-accordion-menu black">
                        {!! $menu_html !!}
                    </div>
                </div>
            </div>
        </div>


        <div class="container box">
            <h1 align="center">Меню</h1>
            <br />
            <div align="right">
                <button type="button" id="modal_button" class="btn btn-info">Создать пункт меню</button>
            </div>
            <br />
            <div id="result" class="table-responsive"></div>
        </div>
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


<script type="text/javascript">
    //обработчик
    jQuery(document).ready(function () {
        jQuery("#jquery-accordion-menu").jqueryAccordionMenu();
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        fetchUser();

        function fetchUser()
        {
            var action = "Load";
            $.ajax({
                url : "/action",
                method:"POST",
                data:{action:action},
                success:function(data){
                    $('#result').html(data);
                }
            });
        }

        $('#modal_button').click(function(){
            $('#customerModal').modal('show');
            $('#title').val('');
            $('#path').val('');
            $('#parent_id').val(0);
            $('.alert-danger').html('');
            $('.alert-danger').css('display','none');
        });


        $('#action').click(function(){
            $('.alert-danger').html('');
            $('.alert-danger').css('display','none');
            var title = $('#title').val();
            var path = $('#path').val();
            var parent_id = $('#parent_id').val();
            var id = $('#menu_id').val();
            var action = $('#action').val();
            if(1)
            {
                $.ajax({
                    url : "action",
                    method:"POST",
                    data:{action:action,title:title, path:path, id:id, parent_id:parent_id},
                    success:function(data){
                        if (data.errors){
                            jQuery.each(data.errors, function(key, value){
                                jQuery('.alert-danger').show();
                                jQuery('.alert-danger').append('<p>'+value+'</p>');
                            });
                        }else{
                            alert(data);
                            $('#customerModal').modal('hide');
                            fetchUser();
                        }
                    }
                });
            }
            else
            {
                alert("Все поля должны быть заполнены.\nНазвание: кириллица/латиница/пробел/цифры.\nСсылка: латиница/цифры.");
            }
        });


        $(document).on('click', '.update', function(){
            var id = $(this).attr("id");
            var action = "Select";
            $.ajax({
                url:"action",
                method:"POST",
                data:{id:id, action:action},
                dataType:"json",
                success:function(data){
                    $('#customerModal').modal('show');
                    $('.modal-title').text("Обновить записи");
                    $('#action').val("Обновить");
                    $('#menu_id').val(id);
                    $('#title').val(data.title);
                    $('#path').val(data.path);
                    $('#parent_id').val(data.parent_id);
                }
            });
        });


        $(document).on('click', '.delete', function(){
            var id = $(this).attr("id");
            if(confirm("Вы уверены что хотите удалить пункт меню и все его дочерние пункты?"))
            {
                var action = "Delete";
                $.ajax({
                    url:"action",
                    method:"POST",
                    data:{id:id, action:action},
                    success:function(data)
                    {
                        fetchUser();
                        alert(data);
                    }
                })
            }
            else
            {
                return false;
            }
        });
    });
</script>


</html>
