<?php
// ===== 1. CONTROLLER: AuthController.php =====
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Log activity
            Log::createLog(Auth::id(), 'Login', 'User logged in');

            // Redirect berdasarkan role
            if (Auth::user()->isSuperAdmin()) {
            return redirect()->route('dashboard.superadmin');
            } else {
             return redirect()->route('dashboard.pegawai');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // Log activity before logout
        if (Auth::check()) {
            Log::createLog(Auth::id(), 'Logout', 'User logged out');
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}