<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function coming_soon(){
        return view("404");
    }
    public function index(){
        return view('home.index');
    }
}
