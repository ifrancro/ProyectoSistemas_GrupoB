<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    /**
     * Muestra el formulario de login para administradores
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /**
     * Procesa el login de administradores
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Buscar administrador por username y que esté activo
        $admin = AdminUser::where('username', $credentials['username'])
                          ->where('activo', true)
                          ->first();

        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            // Login usando el guard admin
            Auth::guard('admin')->login($admin);
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'username' => 'Usuario o contraseña inválidos.',
        ]);
    }

    /**
     * Cierra la sesión del administrador
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }
}
