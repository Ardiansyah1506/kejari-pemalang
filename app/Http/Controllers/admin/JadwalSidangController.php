<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalSidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalSidangController extends Controller
{
    public function index()
    {
        $pageTitle = 'Manajemen Jadwal Sidang';
        $user = Auth::user();
        if (Auth::check()) {
        return view('admin.jadwal_sidang.index', compact('user', 'pageTitle'));
        } else {
            return redirect('home')->with('alert', 'Silahkan login terlebih dahulu!');
        }
    }

    public function getData()
    {
        $jadwalSidang = JadwalSidang::orderBy('created_at', 'desc')->get();

        return datatables()->of($jadwalSidang)
            ->addColumn('action', function ($row) {
                return '
                <div class="flex justify-start space-x-2 text-xl">
            <!-- Show Button -->
            <button class="btn-show text-yellow-300  hover:text-yellow-400 " data-id="' . $row->id . '">
                <i class="fa-solid fa-eye"></i>
            </button>

            <!-- Edit Button -->
            <button class="btn-edit text-gray-600  hover:text-gray-700" data-id="' . $row->id . '">
                <i class="fa-solid  fa-pen-to-square"></i>
            </button>

            <!-- Delete Button -->
            <button class="btn-delete text-red-500 hover:text-red-700" data-id="' . $row->id . '">
                <i class="fa-solid fa-trash-can"></i>
            </button>
        </div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // Function to store a new record in the database
    public function store(Request $request)
    {
        $request->validate([
            'perkara' => 'nullable|string',
            'tanggal_sidang' => 'nullable|date',
            'penggugat' => 'nullable|string',
            'tergugat' => 'nullable|string',
            'agenda' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        JadwalSidang::create($request->all());

        return redirect()->route('admin.sidang.index')
            ->with('success', 'Jadwal sidang berhasil ditambahkan.');
    }

    public function show($id)
    {
        $jadwalSidang = JadwalSidang::findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Detail Jadwal Sidang berhasil diambil',
            'data' => $jadwalSidang,
        ]);
    }

    // Menampilkan data untuk halaman edit
    public function edit($id)
    {
        $jadwalSidang = JadwalSidang::findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Data Jadwal Sidang berhasil diambil untuk diedit',
            'data' => $jadwalSidang,
        ]);
    }

    // Function to update a specific record in the database
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'perkara' => 'nullable|string',
            'tanggal_sidang' => 'nullable|date',
            'penggugat' => 'nullable|string',
            'tergugat' => 'nullable|string',
            'agenda' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $jadwalSidang = JadwalSidang::findOrFail($request->id);
        $jadwalSidang->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Jadwal Sidang berhasil diupdate',
        ]);
    }

    // Function to delete a specific record from the database
    public function destroy($id)
    {
        $jadwalSidang = JadwalSidang::findOrFail($id);
        $jadwalSidang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jadwal Sidang berhasil dihapus',
        ]);
    }
}
