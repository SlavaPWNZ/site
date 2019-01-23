<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $timestamps = FALSE;
    public $result=[];

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

    public static function getIDs(){
        $result=[];
        $i = 0;
        $rows= Menu::select('id')
            ->orderBy('id', 'asc')
            ->distinct()
            ->get();
        foreach ($rows as $row){
            $result[$i]['id']=$row->id;
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

    public static function getRowMenu($id){
        $result=[];
        $i = 0;
        $rows= Menu::where('id', $id)
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

    public static function updateRowMenu($id,$title, $path, $parent_id){
        try {
            $result= Menu::where('id', $id)
                ->update(['title' => $title, 'path' => $path, 'parent_id' => $parent_id]);
        } catch(\Illuminate\Database\QueryException $ex){
            $result=[];
        }
        return $result;
    }

    public static function deleteTree($id){
        $i = 0;
        $rows= Menu::where('parent_id', $id)->get();
        foreach ($rows as $row){
            Menu::deleteTree($row->id);
            Menu::where('id', $row->id)->delete();
            $i++;
        }
    }

    public static function deleteRow($id){
        Menu::where('id', $id)->delete();
        Menu::deleteTree($id);
        return true;
    }

    public static function getTitleEditor($path){
        $result='';
        $rows= Menu::where('path', $path)
            ->get();
        foreach ($rows as $row){
            $result=$row->title;
        }
        return $result;
    }
}