jQuery(document).ready(function () {
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
                $('#jquery-accordion-menu').html(data[0]);
                jQuery("#jquery-accordion-menu").jqueryAccordionMenu();
                $('#result').html(data[1]);
                $('#parent_id').html(data[2]);
            }
        });
    }


    $(document).on('click', '#modal_button',function(){
        $('#customerModal').modal('show');
        $('#title').val('');
        $('#path').val('');
        $('#parent_id').val(0);
        $('.alert-danger').html('');
        $('.alert-danger').css('display','none');
    });


    $(document).on('click', '#action',function(){
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
                    }else if (data=='Вы ничего не изменили!'){
                        jQuery('.alert-danger').show();
                        jQuery('.alert-danger').append('<p>Вы ничего не изменили!</p>');
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
        $('.alert-danger').html('');
        $('.alert-danger').css('display','none');
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