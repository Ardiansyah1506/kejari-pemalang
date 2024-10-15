<?php

namespace App\Http\Controllers\admin;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index()
    {
        $pageTitle = 'Berita';
        if (Auth::check()) {
            return view('admin.berita.index', compact('pageTitle'));
        } else {
            return redirect('/')->with('alert', 'Silahkan login terlebih dahulu!');
        }
    }

    public function getData()
    {
        $berita = Berita::all();
        return datatables()->of($berita)
            ->addColumn('action', function ($row) {
                return '
                <div class="p-3 px-5 flex justify-end">
                    <button type="button"
                        class="edit-btn mr-3 text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline" data-id="' . $row->id . '">Edit</button>
                    <button type="button"
                        class="btn-delete text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline" data-id="' . $row->id . '">Delete</button>
                </div>
                ';
            })
            ->make(true);
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $publisher = Auth::user()->username;
        $berita = new Berita();
        $berita->judul = $request->judul;
        $berita->deskripsi = $request->deskripsi;
        $berita->publisher = $publisher;

       
    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        // Simpan gambar di public/foto_berita
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('foto_berita'), $fileName);
        $berita->foto = $fileName; // simpan nama file
    }

        $berita->save();

        return redirect()->back()->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $berita = Berita::find($id);
        return response()->json($berita);
    }

    public function update(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $id= $request->id;
        $berita = Berita::find($id);
        $berita->judul = $request->judul;
        $berita->deskripsi = $request->deskripsi;
        if (!$berita) {
            Log::error("Berita dengan ID {$id} tidak ditemukan.");
            return redirect()->back()->withErrors(['error' => 'Berita tidak ditemukan.']);
        }
        Log::info("Memperbarui berita ID {$id}: ", [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'foto' => $request->hasFile('foto') ? 'Ada' : 'Tidak ada',
        ]);
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($berita->foto) {
                Storage::disk('public')->delete($berita->foto);
            }
            $file = $request->file('foto');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('foto_berita'), $fileName);
            $berita->foto = $fileName; // simpan nama file
        }

        $berita->save();
        Log::info("Berita ID {$id} berhasil diperbarui.");

        return redirect()->back()->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $berita = Berita::find($id);
        if ($berita->foto) {
            Storage::disk('public')->delete($berita->foto);
        }
        $berita->delete();
        
        return response()->json(['success' => 'Berita berhasil dihapus.']);
    }
}
