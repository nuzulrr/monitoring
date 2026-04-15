<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Tambahkan ini
use App\Models\User;

class LoginController extends Controller
{
    // Menampilkan halaman login
    public function index()
    {
        return view('auth.login');
    }

    // Proses login (method authenticate sesuai web.php)
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/home');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Proses Register (Opsional)
    
public function showRegisterForm()
{
    return view('auth.register');
}
    public function register(Request $request)
    {
        // Gabungkan validasi standar dan validasi Secret Code dari .env
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'secret_code' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Mencocokkan input dengan REGISTRATION_SECRET di file .env
                    if ($value !== env('REGISTRATION_SECRET')) {
                        $fail('Kode rahasia salah. Anda tidak memiliki izin untuk mendaftar.');
                    }
                },
            ],
        ]);

        // Jika validasi lolos, buat user baru
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Pendaftaran berhasil. Silakan login.');
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
    
}