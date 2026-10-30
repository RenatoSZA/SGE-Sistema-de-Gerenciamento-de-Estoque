<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('matricula', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%");
            });
        }

        $employees = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.manage');
    }

    public function store(Request $request)
    {
        $request->merge([
            'cpf' => preg_replace('/[^0-9]/', '', $request->cpf ?? ''),
            'name' => $request->input('name', $request->input('nome')),
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc', 'max:255', 'unique:users'],
            'cpf' => ['required', 'string', 'size:11', 'unique:users', new \App\Rules\CpfValidationRule()],
            'nivel_acesso' => ['required', 'in:Funcionario,Gerente,Admin'],
            'departamento' => ['required', 'string', 'max:255'],
            'horario_entrada' => ['nullable', 'date_format:H:i'],
            'horario_saida' => ['nullable', 'date_format:H:i'],
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

        $matricula = DB::transaction(function () use ($validated, $prefix, $year) {
            $latestUser = User::where('matricula', 'like', $prefix . $year . '%')
                ->lockForUpdate()
                ->orderBy('matricula', 'desc')
                ->first();

            $sequence = 1;
            if ($latestUser) {
                $latestSequence = (int) substr($latestUser->matricula, -4);
                $sequence = $latestSequence + 1;
            }

            $generatedMatricula = $prefix . $year . str_pad($sequence, 4, '0', STR_PAD_LEFT);

            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'cpf' => $validated['cpf'],
                'nivel_acesso' => $validated['nivel_acesso'],
                'departamento' => $validated['departamento'],
                'horario_entrada' => $validated['horario_entrada'] ?? '07:00',
                'horario_saida' => $validated['horario_saida'] ?? '17:00',
                'matricula' => $generatedMatricula,
                'password' => Hash::make('Mudar@123'),
                'data_admissao' => Carbon::now()->toDateString(),
                'is_active' => true,
            ]);

            return $generatedMatricula;
        });

        return redirect()->route('employees.index')->with('success', 'Funcionário cadastrado com sucesso! Matrícula: ' . $matricula);
    }

    public function edit(User $employee)
    {
        if (auth()->user()->nivel_acesso === 'Gerente' && $employee->nivel_acesso === 'Admin') {
            return redirect()->route('employees.index')->with('error', 'Gerentes não têm permissão para gerenciar contas de Administradores.');
        }

        return view('employees.manage', compact('employee'));
    }

    public function update(Request $request, User $employee)
    {
        if (auth()->user()->nivel_acesso === 'Gerente' && $employee->nivel_acesso === 'Admin') {
            return redirect()->route('employees.index')->with('error', 'Gerentes não têm permissão para alterar contas de Administradores.');
        }

        $request->merge([
            'cpf' => preg_replace('/[^0-9]/', '', $request->cpf ?? '')
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc', 'max:255', 'unique:users,email,' . $employee->id],
            'cpf' => ['required', 'string', 'size:11', 'unique:users,cpf,' . $employee->id, new \App\Rules\CpfValidationRule()],
            'nivel_acesso' => ['required', 'in:Funcionario,Gerente,Admin'],
            'departamento' => ['required', 'string', 'max:255'],
            'horario_entrada' => ['nullable', 'date_format:H:i'],
            'horario_saida' => ['nullable', 'date_format:H:i'],
            'is_active' => ['boolean'],
        ]);

        if (auth()->user()->nivel_acesso === 'Gerente' && $validated['nivel_acesso'] === 'Admin') {
            return back()->withErrors(['nivel_acesso' => 'Gerentes não têm permissão para promover a Administradores.'])->withInput();
        }

        DB::transaction(function () use ($request, $employee, $validated) {
            $matricula = $employee->matricula;
            $newPrefix = $validated['nivel_acesso'] === 'Admin' ? 'A' : ($validated['nivel_acesso'] === 'Gerente' ? 'G' : 'F');

            if (!str_starts_with($matricula, $newPrefix)) {
                $year = substr($matricula, 1, 4) ?: date('Y');
                $candidate = $newPrefix . substr($matricula, 1);

                if (User::where('matricula', $candidate)->where('id', '!=', $employee->id)->exists()) {
                    $latestUser = User::where('matricula', 'like', $newPrefix . $year . '%')
                        ->lockForUpdate()
                        ->orderBy('matricula', 'desc')
                        ->first();
                    $sequence = $latestUser ? ((int) substr($latestUser->matricula, -4)) + 1 : 1;
                    $candidate = $newPrefix . $year . str_pad($sequence, 4, '0', STR_PAD_LEFT);
                }
                $matricula = $candidate;
            }

            $employee->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'cpf' => $validated['cpf'],
                'nivel_acesso' => $validated['nivel_acesso'],
                'matricula' => $matricula,
                'departamento' => $validated['departamento'],
                'horario_entrada' => $validated['horario_entrada'] ?? $employee->horario_entrada ?? '07:00',
                'horario_saida' => $validated['horario_saida'] ?? $employee->horario_saida ?? '17:00',
                'is_active' => $request->has('is_active'),
            ]);
        });

        return redirect()->route('employees.index')->with('success', 'Funcionário atualizado com sucesso!');
    }

    public function resetPassword(User $employee)
    {
        if (auth()->user()->nivel_acesso === 'Gerente' && $employee->nivel_acesso === 'Admin') {
            return redirect()->route('employees.index')->with('error', 'Gerentes não têm permissão para redefinir senha de Administradores.');
        }

        $employee->update([
            'password' => Hash::make('Mudar@123'),
        ]);

        return back()->with('success', 'Senha redefinida para o padrão (Mudar@123) com sucesso!');
    }

    public function destroy(User $employee)
    {
        if (auth()->id() === $employee->id) {
            return back()->withErrors(['error' => 'Você não pode excluir seu próprio usuário.']);
        }

        if (auth()->user()->nivel_acesso === 'Gerente' && $employee->nivel_acesso === 'Admin') {
            return redirect()->route('employees.index')->with('error', 'Gerentes não têm permissão para excluir Administradores.');
        }

        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Funcionário excluído com sucesso!');
    }
}
