<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Menu;

class MenuController extends Controller
{
    public function index(){
        $parentsID = Menu::getParentsID();
        return view('menu', ['parentsID' => $parentsID]);
    }
}
