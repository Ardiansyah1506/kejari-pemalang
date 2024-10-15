<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function actionLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'], // validasi string untuk username
            'password' => ['required', 'string'], // validasi string untuk password
        ]);

        // Auth attempt login
        if (Auth::attempt($credentials)) {
            $id = Auth::user()->id;
            $user = User::find($id);
            $user->is_online = true; // Set status online
            $user->last_login = now(); // Atur waktu login terakhir
            $user->save(); // Ini seharusnya tidak memunculkan error

            return redirect()->route('admin.user.index'); // Redirect ke route 'dashboard' jika login berhasil
        } else {
            Session::flash('error', 'Username atau Password salah'); // Set flash message error
            return redirect('/'); // Redirect kembali ke halaman login
        }
    }


    // return redirect('register');
    public function logout()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $user->is_online = false;
        $user->save();
        Auth::logout();
        return redirect('/');
    }
}
