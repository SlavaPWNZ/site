<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Menu;

class MenuController extends Controller
{
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

    public function index(){
        $categories = Menu::makeMenu();
        $menu_html=$this->build_tree($categories);
        $parentsID = Menu::getParentsID();
        return view('menu', ['menu_html' => $menu_html, 'parentsID' => $parentsID,]);
    }
}
