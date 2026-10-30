<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class SiteController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

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

        $throttleKey = Str::transliterate(Str::lower($credentials['matricula']).'|'.$request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'matricula' => "Muitas tentativas de login. Tente novamente em {$seconds} segundos.",
            ])->onlyInput('matricula');
        }

        $user = User::where('matricula', $credentials['matricula'])->first();

        if ($user && !$user->is_active) {
            RateLimiter::hit($throttleKey);
            return back()->withErrors([
                'matricula' => 'Sua conta está inativa. Entre em contato com o administrador.',
            ])->onlyInput('matricula');
        }

        if (auth()->attempt(['matricula' => $credentials['matricula'], 'password' => $credentials['password'], 'is_active' => true])) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        RateLimiter::hit($throttleKey);

        return back()->withErrors([
            'matricula' => 'As credenciais informadas não correspondem aos nossos registros.',
        ])->onlyInput('matricula');
    }
}
