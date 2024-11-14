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
            'nim' => 'nullable|string|max:20',
            'no_hp' => 'nullable|string|max:15|regex:/^([0-9\s\-\+\(\)]*)$/', // Adding phone number regex
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // Adding password confirmation rule
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
            'password' => 'required|min:8',
        ]);

        // Cek apakah pengguna ingin diingat (remember me)
        $remember = $request->has('remember');

        // Cek kredensial login
        if (Auth::attempt($credentials, $remember)) {
            // Jika login berhasil, regenerasi session
            $request->session()->regenerate();

            // Ambil user yang login
            $user = Auth::user();

            // Redirect berdasarkan peran
            if ($user->role === 'admin') {
                return redirect()->intended('/admindashboard');
            } else {
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

        return redirect('/login');
    }

    // Show Users Method for Admin
    public function showUsers()
    {
        $users = User::where('role', '!=', 'admin')->paginate(10);
        return view('admin.datapengguna', compact('users'));
    }

    // Destroy User Method for Admin
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil dihapus.');
    }
}
