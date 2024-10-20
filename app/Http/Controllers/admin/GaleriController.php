<?php

namespace App\Http\Controllers\admin;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        $galeri = Galeri::all();
        $user= Auth::user();
        $pageTitle = 'Berita';
        if (Auth::check()) {
            return view('admin.galeri.index', compact('user','pageTitle','galeri'));
        } else {
            return view('home')->with('alert', 'Silahkan login terlebih dahulu!');
        }
    }


    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $galeri = new Galeri();
        $galeri->judul = $request->judul;

       
    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        // Simpan gambar di public/foto_berita
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('foto_galeri'), $fileName);
        $galeri->foto = $fileName; // simpan nama file
    }

        $galeri->save();

        return redirect()->back()->with('success', 'Galeri berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $galeri = Galeri::find($id);
        return response()->json($galeri);
    }

    public function update(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $id= $request->id;
        $galeri = Galeri::find($id);
        $galeri->judul = $request->judul;
        if (!$galeri) {
            Log::error("Galeri dengan ID {$id} tidak ditemukan.");
            return redirect()->back()->withErrors(['error' => 'Galeri tidak ditemukan.']);
        }
        Log::info("Memperbarui galeri ID {$id}: ", [
            'judul' => $request->judul,
            'foto' => $request->hasFile('foto') ? 'Ada' : 'Tidak ada',
        ]);
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($galeri->foto) {
                Storage::disk('public')->delete($galeri->foto);
            }
            $file = $request->file('foto');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('foto_galeri'), $fileName);
            $galeri->foto = $fileName; // simpan nama file
        }

        $galeri->save();
        Log::info("Galeri ID {$id} berhasil diperbarui.");

        return redirect()->back()->with('success', 'Galeri berhasil diperbarui.');
    }

    public function search(Request $request)
    {
        $query = $request->input('search');
        $galeri = Galeri::where('judul', 'LIKE', '%' . $query . '%')->get();
    
        return response()->json($galeri);
    }
    public function destroy($id)
    {
        $galeri = Galeri::find($id);
        if ($galeri->foto) {
            Storage::disk('public')->delete($galeri->foto);
        }
        $galeri->delete();
        
        return response()->json(['success' => 'Galeri berhasil dihapus.']);
    }
}
