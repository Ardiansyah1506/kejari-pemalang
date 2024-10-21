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
        $user = Auth::user();
        $pageTitle = 'Manajemen User';
        if (Auth::check()) {
            return view('admin.user.index', compact('user', 'pageTitle'));
        } else {
            return redirect('/')->with('alert', 'Silahkan login terlebih dahulu!');
        }

    }
    public function getData()
    {
        $user = User::orderBy('created_at', 'desc')->get();
        return datatables()->of($user)
            ->addColumn('action', function ($row) {
                return '
                <div class="p-3 px-5 flex justify-end">
                <button class="btn-delete" data-id="' . $row->id . '"><i class="fa-solid text-xl fa-trash-can  text-red-500 hover:text-red-700  py-1 px-2 rounded focus:outline-none focus:shadow-outline"></i></button>
                </div>
                ';
            })

            ->make(true);
    }
    public function tambahUser(Request $request)
    {
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
        return redirect()->back()->with('success', 'Berhasil Menambah User.');

    }

    public function edit($id)
    {
        $berita = User::find($id);
        return response()->json($berita);
    }


    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json(['message' => 'User berhasil dihapus.']);
    }
}
