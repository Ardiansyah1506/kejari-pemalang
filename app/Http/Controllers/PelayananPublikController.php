<?php

namespace App\Http\Controllers;

use App\Models\ForumKonsultasi;
use Illuminate\Http\Request;

class PelayananPublikController extends Controller
{
    public function index() {
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
            ->limit(5)
            ->get();
    // dd($ForumKonsultasi);
        return view('pelayananPublik.index', compact('ForumKonsultasi'));
    }
    

    public function store(Request $request) {
        $credentials = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
            'nohp' => ['required', 'string', 'regex:/^[0-9]{10,15}$/'], // Validasi nomor telepon dengan regex
            'keterangan' => ['required', 'string', 'min:8'], // validasi keterangan minimal 8 karakter
            'dokumen' => ['required', 'file', 'mimes:pdf,doc,docx'], // validasi tipe file
        ]);
    
        $ForumKonsultasi = new ForumKonsultasi();
        $ForumKonsultasi->nama = $request->nama;
        $ForumKonsultasi->email = $request->email;
        $ForumKonsultasi->alamat = $request->alamat;
        $ForumKonsultasi->no_hp = $request->nohp;
        $ForumKonsultasi->keterangan = $request->keterangan;
    
        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('berkas_konsultasi'), $fileName);
            $ForumKonsultasi->dokumen_pendukung = $fileName;
        }
    
        $ForumKonsultasi->save();
    
        return redirect()->back()->with('success', 'Berita berhasil ditambahkan.');
    }
    

    }

