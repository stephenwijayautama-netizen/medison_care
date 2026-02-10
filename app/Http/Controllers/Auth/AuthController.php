<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    public function indexlogin()
    {
        return view('login');
    }
    public function dologin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string', // Sebaiknya gunakan 'email' sebagai tipe validasi
            'password' => 'required|string'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user && in_array($user->role_id, [1, 2], true)) {
                return redirect()->intended('/admin');
            }

            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.', 
        ]);
    }

    public function indexregister()
    {
        $roles = Role::all();

        return view('register', compact('roles'));
    }

    public function doregister(Request $request)
    {

        $credentials = $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email|max:255',
            // 'tanggal_lahir' => 'required|date|before:today',
            'role_id' => 'required|integer|',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'password' => 'required',
                            'string',
                            'min:8',
            'password_confirmation' => 'required',
                                        'string',
                                        'min:8',
        ]);
        
        $user = User::create([
            'name' => $credentials['nama'],
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password']),
            'phone' => $credentials['phone'] ?? null,
            'address' => $credentials['address'] ?? null,
            'role_id' => $credentials['role_id'],
        ]);

        Auth::login($user);
        return redirect()->route('home');

    }
    public function logout(Request $request)
    {
        Auth::logout();                      // Logout user aktif
        $request->session()->invalidate();   // Hapus session lama
        $request->session()->regenerateToken(); // Buat CSRF token baru

        return redirect('/login')->with('success', 'Berhasil logout');
    }
public function forgotPassword()
{
    return view('/forgot');
}

public function sendNewPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->with('error', 'Email tidak terdaftar');
    }

    $newPassword = Str::random(8);

    $user->password = Hash::make($newPassword);
    $user->save();

    // Kirim password baru ke email
    Mail::raw(
        "Halo {$user->name},\n\nPassword baru Anda adalah:\n\n{$newPassword}\n\nSilakan login dan segera ganti password.",
        function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Password Baru Akun Anda');
        }
    );

    return back()->with('success', 'Password baru telah dikirim ke email Anda.');
}

}

;
