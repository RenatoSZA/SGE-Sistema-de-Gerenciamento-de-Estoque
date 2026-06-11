<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'matricula' => ['required', 'string', 'regex:/^[FGA]\d{8}$/'],
            'password' => ['required', 'string'],
        ], [
            'matricula.regex' => 'A matrícula deve iniciar com F, G ou A seguido de 8 números (ex: F20260001).'
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'matricula' => 'As credenciais informadas não correspondem aos nossos registros.',
        ])->onlyInput('matricula');
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
