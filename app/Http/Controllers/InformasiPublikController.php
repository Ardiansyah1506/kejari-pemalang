<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InformasiPublikController extends Controller
{
    public function index(){
        $user = Auth::user();
        $berita = Berita::limit(4)->latest()->get();
        
        // Ambil galeri pertama
        $galeriFirst = Galeri::latest()->first();
        
        // Jika ada galeri pertama, ambil ID-nya, jika tidak biarkan $excludedIds menjadi array kosong
        $excludedIds = $galeriFirst ? [$galeriFirst->id] : [];
        
        // Ambil galeri lain yang tidak termasuk dalam ID galeri pertama
        $galeri = Galeri::whereNotIn('id', $excludedIds)->limit(4)->latest()->get();
        
        // Debugging hasil
        // dd($galeri);
        
        // Kembalikan view dengan data
        return view('informasiPublik.index', compact('user', 'galeri', 'berita', 'galeriFirst'));
    }
    
    public function berita(){
        $user = Auth::user();
        $berita = Berita::latest()->get();
        return view('informasiPublik.berita', compact( 'berita','user'));
    }
    
    public function galeri(){
        $user = Auth::user();
        $galeri = Berita::latest()->get();
        return view('informasiPublik.galeri', compact( 'galeri','user'));
    }
    public function Detailberita($id){
        $user = Auth::user();
        $data = Berita::where('id',$id)->first();
        return view('informasiPublik.detail_berita', compact( 'data','user'));
    }
}
