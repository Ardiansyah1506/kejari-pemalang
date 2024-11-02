<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForumKonsultasi;
use Illuminate\Support\Facades\Auth;

class PelayananPublikController extends Controller
{
    public function index() {
        $user = Auth::user();
        $ForumKonsultasi = ForumKonsultasi::leftJoin('jawaban_konsultasi AS jawaban', 'jawaban.id_forum', '=', 'forum_konsultasi.id')
            ->select(
                'forum_konsultasi.nama', 
                'forum_konsultasi.alamat', 
                'forum_konsultasi.email', 
                'forum_konsultasi.no_hp', 
                'forum_konsultasi.keterangan', 
                'forum_konsultasi.dokumen_pendukung',
                'jawaban.keterangan AS jawaban',
                'jawaban.id_forum'
            )
            ->orderBy('forum_konsultasi.created_at', 'desc') // Mengurutkan berdasarkan created_at secara descending (terbaru dulu)
            ->paginate(8); // Menggunakan paginate dengan limit 8
    
        return view('pelayananPublik.index', compact('user','ForumKonsultasi'));
    }
    
    

    public function store(Request $request) {
        $credentials = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'max:255'],
            'nohp' => ['required', 'string', 'regex:/^[0-9]{10,15}$/'], // Validasi nomor telepon dengan regex
            'keterangan' => ['required', 'string', 'min:8'], // validasi keterangan minimal 8 karakter
            'dokumen' => [ 'nullable','file', 'mimes:pdf,doc,docx'], // validasi tipe file
        ]);
    
        $ForumKonsultasi = new ForumKonsultasi();
        $ForumKonsultasi->nama = $request->nama;
        $ForumKonsultasi->email = $request->email;
        $ForumKonsultasi->alamat = $request->alamat;
        $ForumKonsultasi->no_hp = $request->nohp;
        $ForumKonsultasi->keterangan = $request->keterangan;
    
        if ($request->hasFile('dokumen')) {
            // Ensure the directory exists
            $destinationPath = public_path('berkas_konsultasi');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true); // Create the directory if it does not exist
            }
            
            $file = $request->file('dokumen');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $ForumKonsultasi->dokumen_pendukung = $fileName;
        }
        $ForumKonsultasi->save();
    
        return redirect()->back()->with('success', 'Pengaduan berhasil ditambahkan.');
    }
    

    }

