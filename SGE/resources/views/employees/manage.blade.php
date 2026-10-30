@extends('layouts.sge')

@section('title', isset($employee) ? 'Gerenciar Funcionário' : 'Novo Funcionário')

@section('content')
<section aria-labelledby="heading-gerenciar-funcionario" class="flex-1 bg-brand-brown rounded-3xl p-6 shadow-xl flex flex-col overflow-y-auto custom-scrollbar h-full relative">
    
    <div class="flex justify-between items-start mb-6 border-b border-white/10 pb-4">
        <div>
            <a href="{{ route('employees.index') }}" class="text-brand-yellow hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow rounded px-1 text-sm font-bold flex items-center gap-1 mb-2 transition-colors">
                <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span>Voltar para Lista</span>
            </a>
            <h2 id="heading-gerenciar-funcionario" class="text-white text-xl md:text-2xl font-black tracking-wide">
                {{ isset($employee) ? 'GERENCIAR FUNCIONÁRIO: ' . $employee->matricula : 'NOVO FUNCIONÁRIO' }}
            </h2>
        </div>
        
        @if(isset($employee))
            <div class="bg-brand-yellow/10 border border-brand-yellow/30 px-4 py-2 rounded-lg text-center shadow-inner" aria-label="Status do funcionário: {{ $employee->is_active ? 'Ativo' : 'Inativo' }}">
                <span class="block text-white/80 text-xs font-bold uppercase mb-1">Status</span>
                <span class="block {{ $employee->is_active ? 'text-green-300' : 'text-red-300' }} text-xl font-black">{{ $employee->is_active ? 'Ativo' : 'Inativo' }}</span>
            </div>
        @endif
    </div>

    @if ($errors->any())
        <div role="alert" class="bg-red-500/20 border border-red-400 text-red-300 p-3 rounded-lg mb-4 text-sm font-bold">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($employee) ? route('employees.update', $employee) : route('employees.store') }}" method="POST" class="flex flex-col gap-5 flex-1 max-w-3xl">
        @csrf
        @if(isset($employee))
            @method('PUT')
        @endif
        
        <!-- Linha 1: Nome e CPF -->
        <div class="flex flex-col md:flex-row gap-5">
            <div class="flex-[2]">
                <label for="emp-name" class="block text-white/80 text-xs font-bold mb-1 uppercase tracking-wider">Nome Completo</label>
                <input id="emp-name" type="text" name="name" value="{{ old('name', $employee->name ?? '') }}" required autocomplete="name" aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}" class="w-full bg-white/5 border border-white/20 focus:border-brand-yellow focus:ring-2 focus:ring-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium">
            </div>
            <div class="flex-1">
                <label for="emp-cpf" class="block text-white/80 text-xs font-bold mb-1 uppercase tracking-wider">CPF</label>
                <input id="emp-cpf"
                       x-data="{ 
                           cpf: '{{ old('cpf', $employee->cpf ?? '') }}',
                           mask(val) {
                               return val.replace(/\D/g, '')
                                         .replace(/(\d{3})(\d)/, '$1.$2')
                                         .replace(/(\d{3})(\d)/, '$1.$2')
                                         .replace(/(\d{3})(\d{1,2})/, '$1-$2')
                                         .replace(/(-\d{2})\d+?$/, '$1');
                           }
                       }" 
                       x-init="cpf = mask(cpf)"
                       x-model="cpf" 
                       x-on:input="cpf = mask(cpf)"
                       type="text" name="cpf" required placeholder="000.000.000-00" maxlength="14" aria-invalid="{{ $errors->has('cpf') ? 'true' : 'false' }}" class="w-full bg-white/5 border border-white/20 focus:border-brand-yellow focus:ring-2 focus:ring-brand-yellow text-white placeholder:text-white/50 rounded-lg px-4 py-3 outline-none transition-colors font-medium">
            </div>
        </div>

        <!-- Linha 2: E-mail -->
        <div>
            <label for="emp-email" class="block text-white/80 text-xs font-bold mb-1 uppercase tracking-wider">E-mail Profissional</label>
            <input id="emp-email" type="email" name="email" value="{{ old('email', $employee->email ?? '') }}" required autocomplete="email" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" class="w-full bg-white/5 border border-white/20 focus:border-brand-yellow focus:ring-2 focus:ring-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium">
        </div>

        <!-- Linha 3: Departamento e Nível de Acesso -->
        <div class="flex flex-col md:flex-row gap-5">
            <div class="flex-1">
                <label for="emp-departamento" class="block text-white/80 text-xs font-bold mb-1 uppercase tracking-wider">Departamento</label>
                <input id="emp-departamento" type="text" name="departamento" value="{{ old('departamento', $employee->departamento ?? '') }}" required aria-invalid="{{ $errors->has('departamento') ? 'true' : 'false' }}" class="w-full bg-white/5 border border-white/20 focus:border-brand-yellow focus:ring-2 focus:ring-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium">
            </div>
            <div class="flex-1">
                <label for="emp-nivel-acesso" class="block text-white/80 text-xs font-bold mb-1 uppercase tracking-wider">Nível de Acesso</label>
                <select id="emp-nivel-acesso" name="nivel_acesso" required aria-invalid="{{ $errors->has('nivel_acesso') ? 'true' : 'false' }}" class="w-full bg-brand-brown border border-white/20 focus:border-brand-yellow focus:ring-2 focus:ring-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium">
                    <option value="Funcionario" {{ old('nivel_acesso', $employee->nivel_acesso ?? '') == 'Funcionario' ? 'selected' : '' }}>Funcionário</option>
                    <option value="Gerente" {{ old('nivel_acesso', $employee->nivel_acesso ?? '') == 'Gerente' ? 'selected' : '' }}>Gerente</option>
                    @if(auth()->user()->nivel_acesso === 'Admin' || (isset($employee) && $employee->nivel_acesso === 'Admin'))
                        <option value="Admin" {{ old('nivel_acesso', $employee->nivel_acesso ?? '') == 'Admin' ? 'selected' : '' }}>Administrador</option>
                    @endif
                </select>
            </div>
        </div>
        
        <!-- Linha 4: Horários de Entrada e Saída -->
        <div class="flex flex-col md:flex-row gap-5">
            <div class="flex-1">
                <label for="emp-horario-entrada" class="block text-white/80 text-xs font-bold mb-1 uppercase tracking-wider">Horário de Entrada</label>
                <input id="emp-horario-entrada" type="time" name="horario_entrada" value="{{ old('horario_entrada', isset($employee->horario_entrada) ? substr($employee->horario_entrada, 0, 5) : '07:00') }}" class="w-full bg-white/5 border border-white/20 focus:border-brand-yellow focus:ring-2 focus:ring-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium">
            </div>
            <div class="flex-1">
                <label for="emp-horario-saida" class="block text-white/80 text-xs font-bold mb-1 uppercase tracking-wider">Horário de Saída</label>
                <input id="emp-horario-saida" type="time" name="horario_saida" value="{{ old('horario_saida', isset($employee->horario_saida) ? substr($employee->horario_saida, 0, 5) : '17:00') }}" class="w-full bg-white/5 border border-white/20 focus:border-brand-yellow focus:ring-2 focus:ring-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium">
            </div>
        </div>

        @if(isset($employee))
            <!-- Linha 4: Status -->
            <div class="flex items-center gap-2 mt-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $employee->is_active) ? 'checked' : '' }} class="w-5 h-5 accent-brand-yellow focus:ring-2 focus:ring-brand-yellow rounded">
                <label for="is_active" class="text-white/90 font-bold uppercase tracking-wider text-sm cursor-pointer">Usuário Ativo no Sistema</label>
            </div>
        @else
            <div role="note" class="bg-brand-yellow/10 border border-brand-yellow/30 p-4 rounded-xl mt-2 text-sm text-brand-yellow font-medium">
                <strong class="block mb-1">Aviso Importante:</strong>
                A matrícula será gerada automaticamente. A senha padrão inicial será <strong>Mudar@123</strong>.
            </div>
        @endif

        <div class="flex flex-wrap items-center justify-between gap-3 mt-4 pt-4 border-t border-white/10">
            <div class="flex flex-wrap gap-2">
                @if(isset($employee) && auth()->id() !== $employee->id)
                    <button type="submit" form="delete-employee-form" class="px-4 py-2 rounded-full font-bold bg-red-500/20 text-red-300 hover:bg-red-600 hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-red-400 border border-red-500/40 transition-colors text-xs">
                        Excluir Permanentemente
                    </button>
                @endif
                @if(isset($employee))
                    <button type="submit" form="reset-password-form" class="px-4 py-2 rounded-full font-bold bg-brand-yellow/20 text-brand-yellow hover:bg-brand-yellow hover:text-brand-brown focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow border border-brand-yellow/40 transition-colors text-xs">
                        Resetar Senha (Mudar@123)
                    </button>
                @endif
            </div>
            <div class="flex gap-3">
                <a href="{{ route('employees.index') }}" class="px-6 py-2 rounded-full font-bold text-white hover:bg-white/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow border border-transparent transition-colors">Cancelar</a>
                <button type="submit" class="px-8 py-2 rounded-full font-bold bg-brand-yellow text-brand-brown hover:bg-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white shadow-md transition-colors">
                    {{ isset($employee) ? 'Salvar Alterações' : 'Cadastrar Funcionário' }}
                </button>
            </div>
        </div>
    </form>
    
    @if(isset($employee) && auth()->id() !== $employee->id)
        <form id="delete-employee-form" action="{{ route('employees.destroy', $employee) }}" method="POST" class="hidden" onsubmit="return confirm('Tem certeza que deseja excluir definitivamente este funcionário?');">
            @csrf
            @method('DELETE')
        </form>
    @endif

    @if(isset($employee))
        <form id="reset-password-form" action="{{ route('employees.resetPassword', $employee) }}" method="POST" class="hidden" onsubmit="return confirm('Redefinir a senha deste funcionário para Mudar@123?');">
            @csrf
        </form>
    @endif

</section>
@endsection
