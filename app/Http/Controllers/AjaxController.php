<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Menu;

class AjaxController extends Controller
{
    public function store(Request $request)
    {
        $messages = [
            'title.required'    => 'Укажите название',
            'title.max'    => 'Название не должно быть более 255 символов',
            'title.regex' => 'В названии разрешено использовать только цифры/латиницу/кириллицу/пробел',
            'title.unique'      => 'Уже есть пункт меню, с таким названием',
            'path.required'    => 'Укажите ссылку',
            'path.max'    => 'Ссылку не должна быть более 255 символов',
            'path.regex' => 'В ссылке разрешено использовать только цифры/латиницу/подчеркивание/дефис',
            'path.unique'      => 'Уже есть пункт меню, с такой ссылкой',
            'parent_id.required'    => 'Укажите id родителя',
        ];

        if(isset($_POST["action"]))
        {
            if($_POST["action"] == "Load")
            {
                $result = Menu::getMenu();
                if(count($result))
                {
                    $output = '';
                    $output .= '
                       <table class="table table-bordered">
                        <tr>
                         <th>ID</th>
                         <th>Название</th>
                         <th>Адрес</th>
                         <th>ID родителя</th>
                         <th>Обновить</th>
                         <th>Удалить</th>
                        </tr>
                      ';
                        foreach($result as $row)
                        {
                            $output .= '
                                <tr>
                                 <td>'.$row["id"].'</td>
                                 <td>'.$row["title"].'</td>
                                 <td>'.$row["path"].'</td>
                                 <td>'.$row["parent_id"].'</td>
                                 <td><button type="button" id="'.$row["id"].'" class="btn btn-warning btn-xs update">Обновить</button></td>
                                 <td><button type="button" id="'.$row["id"].'" class="btn btn-danger btn-xs delete">Удалить</button></td>
                                </tr>
                                ';
                        }
                    $output .= '</table>';
                }
                else
                {
                    $output= '<h3>Данных нет</h3>';
                }

                echo $output;
            }
            if($_POST["action"] == "Создать")
            {
                $validator = \Validator::make($request->all(), [
                    'title' => 'bail|required|max:255|regex:/^[0-9a-zA-ZА-Яа-яЁё\s]+$/u|unique:menus,title|',
                    'path' => 'bail|required|max:255|regex:/^[0-9a-zA-Z_-]+$/|unique:menus,path',
                    'parent_id' => 'required',
                ],$messages);
                if ($validator->fails())
                {
                    return response()->json(['errors'=>$validator->errors()->all()]);
                }
                $result = Menu::saveRowMenu($_POST["title"],$_POST["path"],$_POST["parent_id"]);
                if(!empty($result))
                {
                    echo 'Данные успешно записаны';
                }
                else{
                    echo 'Ошибка!';
                }
            }
            if($_POST["action"] == "Select")
            {
                $result = Menu::getRowMenu($_POST["id"]);
                foreach($result as $row)
                {
                    $output["title"] = $row["title"];
                    $output["path"] = $row["path"];
                    $output["parent_id"] = $row["parent_id"];
                }
                echo json_encode($output);
            }
            if($_POST["action"] == "Обновить")
            {
                $validator = \Validator::make($request->all(), [
                    'title' => 'bail|required|max:255|regex:/^[0-9a-zA-ZА-Яа-яЁё\s]+$/|unique:menus,title|',
                    'path' => 'bail|required|max:255|regex:/^[0-9a-zA-Z_-]+$/|unique:menus,path',
                    'parent_id' => 'required',
                ],$messages);
                if ($validator->fails())
                {
                    return response()->json(['errors'=>$validator->errors()->all()]);
                }
                $result = Menu::updateRowMenu($_POST["id"],$_POST["title"],$_POST["path"],$_POST["parent_id"]);
                if(!empty($result))
                {
                    echo 'Данные успешно обновлены';
                }
                else{
                    echo 'Ошибка!';
                }
            }
            if($_POST["action"] == "Delete")
            {
                if ($_POST["id"]==1 || $_POST["id"]==12){
                    echo 'Не стоит удалять главную страницу и страницу первого задания... =)';
                }
                else{
                    $result = Menu::deleteRow($_POST["id"]);
                    if(!empty($result))
                    {
                        echo 'Данные удалены';
                    }
                    else{
                        echo 'Ошибка!';
                    }
                }

            }
        }
    }
}
