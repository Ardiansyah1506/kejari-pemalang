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
        $user = Auth::user();
        if (Auth::check()) {
            return view('admin.berita.index', compact('user', 'pageTitle'));
        } else {
            return redirect('home')->with('alert', 'Silahkan login terlebih dahulu!');
        }
    }

    public function getData()
    {
        $berita = Berita::orderBy('created_at', 'desc')->get();
        return datatables()->of($berita)
            ->addColumn('action', function ($row) {
                return '
                <div class="p-3 px-5 flex justify-end">
                    <button type="button"
                        class="edit-btn  text-xl rounded focus:outline-none focus:shadow-outline" data-id="' . $row->id . '">   <i class="fa-regular fa-pen-to-square text-gray-600 text-md md:text-md py-2 px-2 md:px-4 " "></i></button>
                    <button type="button"
                        class="btn-delete text-xl  py-1  rounded focus:outline-none focus:shadow-outline" data-id="' . $row->id . '"><i class="fa-solid fa-trash-can text-red-500 hover:text-red-300 text-md md:text-md py-2 px-2 md:px-4"></i></button>
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
        // Validasi input
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Ambil data berita berdasarkan ID
        $id = $request->id;
        $berita = Berita::find($id);
        
        if (!$berita) {
            Log::error("Berita dengan ID {$id} tidak ditemukan.");
            return redirect()->back()->withErrors(['error' => 'Berita tidak ditemukan.']);
        }
    
        // Update data berita
        $berita->judul = $request->judul;
        $publisher = Auth::user()->username;
        $berita->publisher = $publisher;
        $berita->deskripsi = $request->deskripsi;
    
        // Log detail update
        Log::info("Memperbarui berita ID {$id}: ", [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'foto' => $request->hasFile('foto') ? 'Ada' : 'Tidak ada',
        ]);
    
        // Proses upload file foto jika ada
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('foto_berita'), $fileName);
            $berita->foto = $fileName; // simpan nama file
        }   
    
        $berita->save();
        Log::info("Berita ID {$id} berhasil diperbarui.");
    
        // Redirect dengan pesan sukses
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
