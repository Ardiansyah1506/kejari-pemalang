<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\ForumKonsultasi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KonsultasiController extends Controller
{
    public function index(){
        if(Auth::check()){
            return view('admin.konsultasi.index');

        }else{
            return view('home.index')->with('alert', 'Silahkan login terlebih dahulu!');
        }
    }

    public function getData()
    {
        $konsultasi = ForumKonsultasi::all();
        return \DataTables::of($konsultasi)
            ->addColumn('action', function ($row) {
                return '
                    <a href="' . route('konsultasi.edit', $row->id) . '" class="btn btn-primary">Edit</a>
                    <form action="' . route('konsultasi.destroy', $row->id) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger" onclick="return confirm(\'Yakin ingin menghapus?\')">Delete</button>
                    </form>
                ';
            })
            ->editColumn('file', function ($row) {
                return '<a href="' . asset('storage/' . $row->file) . '" target="_blank">Lihat Dokumen</a>';
            })
            ->rawColumns(['action', 'file'])
            ->make(true);
    }

    // Menampilkan form tambah data konsultasi
    public function create()
    {
        return view('admin.create');
    }

    // Menyimpan data konsultasi baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Mengunggah file
        $filePath = $request->file('file')->store('konsultasi_files', 'public');

        // Menyimpan data ke database
        ForumKonsultasi::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file' => $filePath,
        ]);

        return redirect()->route('konsultasi.index')->with('success', 'Data berhasil ditambahkan!');
    }

    // Menampilkan form edit data konsultasi
    public function edit($id)
    {
        $konsultasi = ForumKonsultasi::findOrFail($id);
        return view('admin.edit', compact('konsultasi'));
    }

    // Mengupdate data konsultasi
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $konsultasi = ForumKonsultasi::findOrFail($id);
        $filePath = $konsultasi->file;

        // Jika ada file baru, maka hapus file lama dan unggah file baru
        if ($request->hasFile('file')) {
            Storage::disk('public/file_pendukung')->delete($filePath);
            $filePath = $request->file('file')->store('konsultasi_files', 'public');
        }

        $konsultasi->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file' => $filePath,
        ]);

        return redirect()->route('konsultasi.index')->with('success', 'Data berhasil diperbarui!');
    }

    // Menghapus data konsultasi
    public function destroy($id)
    {
        $konsultasi = ForumKonsultasi::findOrFail($id);
        Storage::disk('public/file_pendukung')->delete($konsultasi->file); // Hapus file dari storage
        $konsultasi->delete(); // Hapus data dari database

        return redirect()->route('konsultasi.index')->with('success', 'Data berhasil dihapus!');
    }
}
