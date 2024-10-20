<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\ForumKonsultasi;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\JawabanKonsultasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KonsultasiController extends Controller
{
    public function index()
    {
        $pageTitle = 'Forum Konsultasi';

        // Query untuk data dengan left join dan filter pencarian
        $data = ForumKonsultasi::leftJoin('jawaban_konsultasi AS jawaban', 'jawaban.id_forum', '=', 'forum_konsultasi.id')
            ->select(
                'forum_konsultasi.id',
                'forum_konsultasi.nama',
                'forum_konsultasi.keterangan',
                'jawaban.keterangan AS jawaban',
                'jawaban.id_forum'
            )
            ->paginate(10);

        if (Auth::check()) {
            return view('admin.konsultasi.index', compact('pageTitle', 'data'));
        } else {
            return redirect()->route('home')->with('alert', 'Silahkan login terlebih dahulu!');
        }
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        // Query untuk data dengan filter pencarian
        $data = ForumKonsultasi::leftJoin('jawaban_konsultasi AS jawaban', 'jawaban.id_forum', '=', 'forum_konsultasi.id')
            ->select(
                'forum_konsultasi.id',
                'forum_konsultasi.nama',
                'forum_konsultasi.keterangan',
                'jawaban.keterangan AS jawaban',
                'jawaban.id_forum'
            )
            ->when($search, function ($query, $search) {
                return $query->where('forum_konsultasi.nama', 'LIKE', "%{$search}%")
                    ->orWhere('forum_konsultasi.keterangan', 'LIKE', "%{$search}%");
            })
            ->paginate(10); // Pagination dengan 10 item per halaman

        return response()->json([
            'data' => $data->items(),
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'total' => $data->total(),
        ]);
    }


    public function getData(Request $request)
    {
        // Ambil input pencarian jika ada
        $search = $request->input('search');

        // Query untuk data dengan left join dan filter pencarian
        $data = ForumKonsultasi::leftJoin('jawaban_konsultasi AS jawaban', 'jawaban.id_forum', '=', 'forum_konsultasi.id')
            ->select(
                'forum_konsultasi.id',
                'forum_konsultasi.nama',
                'forum_konsultasi.keterangan',
                'jawaban.keterangan AS jawaban',
                'jawaban.id_forum'
            )
            ->when($search, function ($query) use ($search) {
                // Filter berdasarkan pencarian
                return $query->where('forum_konsultasi.nama', 'like', "%{$search}%")
                    ->orWhere('forum_konsultasi.keterangan', 'like', "%{$search}%");
            })
            ->paginate(10); // Pagination dengan 10 item per halaman

        // Jika request datang dari AJAX, kembalikan data tabel saja
        if ($request->ajax()) {
            return response()->json($data);
        }

        return response()->json(['error' => 'Invalid request'], 400); // Jika bukan AJAX, return error
    }


    public function detail($id)
    {
        $pageTitle = 'Forum Konsultasi';
        $data = ForumKonsultasi::where('forum_konsultasi.id', $id)->leftJoin('jawaban_konsultasi AS jawaban', 'jawaban.id_forum', '=', 'forum_konsultasi.id')
            ->select(
                'forum_konsultasi.id',
                'forum_konsultasi.nama',
                'forum_konsultasi.alamat',
                'forum_konsultasi.email',
                'forum_konsultasi.no_hp',
                'forum_konsultasi.keterangan',
                'forum_konsultasi.dokumen_pendukung',
                'jawaban.keterangan AS jawaban',
                'jawaban.id_forum'
            )
            ->first();
            // dd($data);

        return view('admin.konsultasi.detail', compact('data','pageTitle'));
    }

    // Menampilkan form tambah data konsultasi
    // Menyimpan data konsultasi baru
    public function storeJawaban(Request $request)
    {
        $request->validate([
            'id_forum' => 'required',
            'deskripsi' => 'required|string',
        ]);


        // Menyimpan data ke database
        JawabanKonsultasi::create([
            'id_forum' => $request->id_forum,
            'keterangan' => $request->deskripsi,
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
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
