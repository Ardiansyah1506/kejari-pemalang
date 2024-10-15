<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InformasiPublikController extends Controller
{
    public function index(){
        return view('informasiPublik.index');
    }
}
