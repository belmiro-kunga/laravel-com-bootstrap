<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AuditService;

class LoginController extends Controller
{
    /**
     * Mostrar o formulário de login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }
    
    /**
     * Processar a tentativa de login
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Log de auditoria de login (agora assíncrono)
            AuditService::logLogin(Auth::user());
            
            return redirect()->intended(route('dashboard.index'));
        }
        
        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ]);
    }
    
    /**
     * Processar o logout
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Log de auditoria de logout (após o logout para não afetar a performance)
        if ($user) {
            AuditService::logLogout($user);
        }
        
        $redirectTo = $request->input('redirect_to');
        if ($redirectTo) {
            return redirect($redirectTo);
        }
        
        return redirect()->route('home');
    }
}