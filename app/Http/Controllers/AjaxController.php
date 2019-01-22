<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Menu;

class AjaxController extends Controller
{
    public function main()
    {
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
                $result = Menu::saveRowMenu($_POST["title"],$_POST["path"],$_POST["parent_id"]);
                if(!empty($result))
                {
                    echo 'Данные успешно записаны';
                }
            }


            if($_POST["action"] == "Select")
            {
                $output = array();
                $statement = $connection->prepare(
                    "SELECT * FROM clients 
   WHERE id = '".$_POST["id"]."' 
   LIMIT 1"
                );
                $statement->execute();
                $result = $statement->fetchAll();
                foreach($result as $row)
                {
                    $output["firstname"] = $row["firstname"];
                    $output["lastname"] = $row["lastname"];
                }
                echo json_encode($output);
            }
            if($_POST["action"] == "Обновить")
            {
                $statement = $connection->prepare(
                    "UPDATE clients 
   SET firstname = :firstname, lastname = :lastname 
   WHERE id = :id
   "
                );
                $result = $statement->execute(
                    array(
                        ':firstname' => $_POST["firstName"],
                        ':lastname' => $_POST["lastName"],
                        ':id'   => $_POST["id"]
                    )
                );
                if(!empty($result))
                {
                    echo 'Данные обновлены';
                }
            }
//Удаляем из базы запись
            if($_POST["action"] == "Delete")
            {
                $statement = $connection->prepare(
                    "DELETE FROM clients WHERE id = :id"
                );
                $result = $statement->execute(
                    array(
                        ':id' => $_POST["id"]
                    )
                );
                if(!empty($result))
                {
                    echo 'Данные удалены';
                }
            }
        }
    }
}
