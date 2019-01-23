<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Menu;

class AjaxController extends Controller
{
    public $messages = [
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

    public function build_tree($categories){
        if (isset($categories[0])){
            $tree = '<ul id="demo-list" type="circle">';
            foreach($categories[0] as $cat){
                $tree .= '<li><a href="'.$cat['path'].'">'.$cat['title'].'</a>';
                $tree .=  $this->build_tree_childrens($categories,$cat['id']);
                $tree .= '</li>';
            }
            $tree .= '</ul>';
            return $tree;
        }
        return null;
    }

    public function build_tree_childrens($categories,$parent_id){
        if(is_array($categories) and isset($categories[$parent_id])){
            $tree = '<ul class="submenu">';
            foreach($categories[$parent_id] as $cat){
                $tree .= '<li><a href="'.$cat['path'].'">'.$cat['title'].'</a>';
                $tree .=  $this->build_tree_childrens($categories,$cat['id']);
                $tree .= '</li>';
            }
            $tree .= '</ul>';
        }
        else return null;
        return $tree;
    }

    public function post_load()
    {
        $categories = Menu::makeMenu();
        $menu_html=$this->build_tree($categories);

        $result = Menu::getMenu();
        $uri=substr($_POST["uri"],1);
        if ( $uri == '') $uri = '/';
        $title_editor=Menu::getTitleEditor($uri);
        $output=view('editor', ['result' => $result, 'title_editor' => $title_editor])->render();

        $IDs=Menu::getIDs();
        $select='<option>0</option>';
        foreach ($IDs as $ID) {
            $select .= '<option>' . $ID['id'] . '</option>';
        }

        $data[0]=$menu_html;
        $data[1]=$output;
        $data[2]=$select;
        return $data;
    }

    public function post_create($request)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'bail|required|max:255|regex:/^[0-9a-zA-ZА-Яа-яЁё\s]+$/u|unique:menus,title|',
            'path' => 'bail|required|max:255|regex:/^[0-9a-zA-Z_-]+$/|unique:menus,path',
            'parent_id' => 'required',
        ],$this->messages);
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

    public function post_select()
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

    public function post_update($request)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'bail|required|max:255|regex:/^[0-9a-zA-ZА-Яа-яЁё\s]+$/|',
            'path' => 'bail|required|max:255|regex:/^[0-9a-zA-Z_-]+$/',
            'parent_id' => 'required',
        ],$this->messages);
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
            echo 'Вы ничего не изменили, либо указали уже занятые название/ссылку';
        }
    }

    public function post_delete()
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

    public function store(Request $request)
    {
        if(isset($_POST["action"]))
        {
            if($_POST["action"] == "Load") return $this->post_load();
            elseif($_POST["action"] == "Создать") return $this->post_create($request);
            elseif($_POST["action"] == "Select") return $this->post_select();
            elseif($_POST["action"] == "Обновить") return $this->post_update($request);
            elseif($_POST["action"] == "Delete") return $this->post_delete();
        }
    }
}
