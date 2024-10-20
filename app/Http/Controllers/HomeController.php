<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function coming_soon(){
        return view("404");
    }
    public function index(){
        $data = Berita::limit(6)->get();
        return view('home.index' ,compact('data'));
    }

    
}
