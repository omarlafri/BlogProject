<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class testControler extends Controller
{
    public function myFucntion(){
        return response()->json([
            'msg'=>'nv file'
            ]);
    }

    public function anyRoute(){
        return view('welcome');
    }

    public function home(){
        return view('welcome');
    }

    public function test2(){
        return 'its working';

    }
}
