<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Galeri;
use Illuminate\Http\Request;

class InformasiPublikController extends Controller
{
    public function index(){
        $berita = Berita::limit(4)->latest()->get();
        $galeri = Galeri::limit(4)->latest()->get();
        $excludedIds = $galeri->pluck('id'); // Mengambil daftar ID dari 4 berita pertama
        $galeriFirst = Galeri::whereNotIn('id', $excludedIds)->first();
        // dd($galeriFirst);
        return view('informasiPublik.index' ,compact('galeri','berita','galeriFirst'));
    }
}
