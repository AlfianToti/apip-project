<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Handle registration of new users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // Validasi input dari form register
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
           
        ]);

        // Cek jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Buat pengguna baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nim' => $request->nim,
            'no_hp' => $request->no_hp,
            'role' => 'pengguna',  // Set default role as 'pengguna'
        ]);

        // Redirect ke halaman login setelah registrasi berhasil
        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }

     // Login Method
     public function login(Request $request)
     {
         // Validasi input dari form login
         $credentials = $request->validate([
             'email' => 'required|email',
             'password' => 'required|min:2',
         ]);
 
         // Cek kredensial login
         if (Auth::attempt($credentials, $request->remember)) {
            // Jika login berhasil, regenerasi session
            $request->session()->regenerate();
    
            // Ambil user yang login
            $user = Auth::user();
    
            // Cek apakah user adalah admin
            if ($user->role === 'admin') {
                // Redirect ke halaman admin jika user adalah admin
                return redirect()->intended('/masteradmin');
            } else {
                // Redirect ke halaman user biasa jika bukan admin
                return redirect()->intended('/masterpengguna');
            }
        }
 
         // Jika login gagal, redirect kembali ke halaman login dengan pesan error
         return back()->withErrors([
             'email' => 'Email atau password salah.',
         ])->withInput($request->except('password'));
     }
 
     // Logout Method
     public function logout(Request $request)
     {
         Auth::logout();
 
         $request->session()->invalidate();
         $request->session()->regenerateToken();
 
         return redirect('/');
     }
}
