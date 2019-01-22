<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $timestamps = FALSE;

    public static function makeMenu(){
        $res=[];
        $cats = Menu::getMenu();
        foreach ($cats as $cat){
            $cats_ID[$cat['id']][] = $cat;
            $res[$cat['parent_id']][$cat['id']] =  $cat;
        }
        return $res;
    }

    public static function getMenu(){
        $result=[];
        $i = 0;
        $rows= Menu::select('id','title', 'path', 'parent_id')
            ->orderBy('parent_id', 'asc')
            ->get();
        foreach ($rows as $row){
            $result[$i]['id']=$row->id;
            $result[$i]['title']=$row->title;
            $result[$i]['path']=$row->path;
            $result[$i]['parent_id']=$row->parent_id;
            $i++;
        }
        return $result;
    }

    public static function getParentsID(){
        $result=[];
        $i = 0;
        $rows= Menu::select('parent_id')
            ->orderBy('parent_id', 'asc')
            ->distinct()
            ->get();
        foreach ($rows as $row){
            $result[$i]['parent_id']=$row->parent_id;
            $i++;
        }
        return $result;
    }

    public static function saveRowMenu($title, $path, $parent_id){
        $row = new Menu;
        $row->title = $title;
        $row->path = $path;
        $row->parent_id = $parent_id;
        $result=$row->save();
        return $result;
    }
}