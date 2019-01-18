<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PregReplace extends Controller
{
    public function index(){
        $pattern = '/[\.]?0*$/'; //удаляем все нули прилигаюшие к концу строки, и символ точки, если он прилегает к нулю.
        $input=['55.100', '55.01', '50.001', '55.0010', '50.00'];
        $output=[];
        foreach ($input as $num) {
            $output[]=preg_replace($pattern, '', $num);
        }
        return view('preg_replace', ['input' => $input, 'output' => $output]);
    }
}
