<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\JadwalSidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function coming_soon(){
        return view("404");
    }
    public function index(){
        $user = Auth::user();
        $data = Berita::orderBy('created_at', 'desc')->limit(6)->get();
        return view('home.index' ,compact('user','data'));
    }

    public function getData()
{
    $jadwalSidang = JadwalSidang::orderBy('created_at', 'desc')->get();
    return response()->json(['data' => $jadwalSidang]);
}


    
}
