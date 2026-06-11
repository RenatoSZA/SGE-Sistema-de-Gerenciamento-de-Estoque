<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'cpf' => ['required', 'string', 'max:14', 'unique:users'],
            'nivel_acesso' => ['required', 'in:Funcionario,Gerente,Admin'],
            'departamento' => ['required', 'string', 'max:255'],
        ]);

        if (auth()->user()->nivel_acesso === 'Gerente' && $validated['nivel_acesso'] === 'Admin') {
            return back()->withErrors(['nivel_acesso' => 'Gerentes não têm permissão para cadastrar Administradores.'])->withInput();
        }

        $year = date('Y');
        
        $prefix = 'F';
        if ($validated['nivel_acesso'] === 'Gerente') {
            $prefix = 'G';
        } elseif ($validated['nivel_acesso'] === 'Admin') {
            $prefix = 'A';
        }

        // Generate matricula
        // Get the latest user hired this year with the same prefix to increment the number
        $latestUser = User::where('matricula', 'like', $prefix . $year . '%')
            ->orderBy('matricula', 'desc')
            ->first();

        $sequence = 1;
        if ($latestUser) {
            $latestSequence = (int) substr($latestUser->matricula, -4);
            $sequence = $latestSequence + 1;
        }

        $matricula = $prefix . $year . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        $user = User::create([
            'name' => $validated['nome'],
            'email' => $validated['email'],
            'cpf' => $validated['cpf'],
            'nivel_acesso' => $validated['nivel_acesso'],
            'departamento' => $validated['departamento'],
            'matricula' => $matricula,
            'password' => Hash::make('Mudar@123'),
            'data_admissao' => Carbon::now()->toDateString(),
        ]);

        return back()->with('success', 'Funcionário cadastrado com sucesso! Matrícula: ' . $matricula);
    }
}
