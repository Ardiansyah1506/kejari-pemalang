<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index()
    {
        $pageTitle = 'Manajemen User';
        if (Auth::check()) {
            return view('admin.user.index', compact('pageTitle'));
        } else {
            return redirect('/')->with('alert', 'Silahkan login terlebih dahulu!');
        }
        
    }
    public function getData()
    {
        $user = User::all();
        return datatables()->of($user)
        ->addColumn('action', function ($row) {
                return '
                <div class="p-3 px-5 flex justify-end">
                    <button type="button"
                        class="btn-delete text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline" data-id="' . $row->id . '">Delete</button>
                </div>
                ';
            })
            
            ->make(true);
    }
    public function tambahUser(Request $request){
        $credentials = $request->validate([
            'username' => ['required', 'string', 'max:255'], // validasi username
            'password' => ['required', 'string', 'min:8'], // validasi password minimal 8 karakter
        ]);
    
        // Menyimpan data user ke dalam database
        $user = new User();
        $user->username = $credentials['username'];
        $user->password = Hash::make($credentials['password']); // hashing password sebelum disimpan
        $user->save();
        // dd($user);
        // Set session flash message
        return redirect()->back()->with('success', 'Register Berhasil. Akun Anda sudah aktif, silakan login menggunakan email dan password.');

    }

    public function edit($id)
    {
        $berita = User::find($id);
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
        $user = User::find($id);
        $user->judul = $request->judul;
        $user->deskripsi = $request->deskripsi;
        if (!$user) {
            Log::error("User dengan ID {$id} tidak ditemukan.");
            return redirect()->back()->withErrors(['error' => 'User tidak ditemukan.']);
        }
       

        $user->save();
        Log::info("Berita ID {$id} berhasil diperbarui.");

        return redirect()->back()->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        
        return response()->json(['success' => 'User berhasil dihapus.']);
    }
}
