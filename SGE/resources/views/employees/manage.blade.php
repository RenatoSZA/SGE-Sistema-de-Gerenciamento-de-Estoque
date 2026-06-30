@extends('layouts.sge')

@section('title', isset($employee) ? 'Gerenciar Funcionário' : 'Novo Funcionário')

@section('content')
<section class="flex-1 bg-brand-brown rounded-3xl p-6 shadow-xl flex flex-col overflow-y-auto custom-scrollbar h-full relative">
    
    <div class="flex justify-between items-start mb-6 border-b border-white/10 pb-4">
        <div>
            <a href="{{ route('employees.index') }}" class="text-brand-yellow/80 hover:text-brand-yellow text-sm font-bold flex items-center gap-1 mb-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Voltar para Lista
            </a>
            <h2 class="text-white text-xl md:text-2xl font-black tracking-wide">
                {{ isset($employee) ? 'GERENCIAR FUNCIONÁRIO: ' . $employee->matricula : 'NOVO FUNCIONÁRIO' }}
            </h2>
        </div>
        
        @if(isset($employee))
            <div class="bg-brand-yellow/10 border border-brand-yellow/30 px-4 py-2 rounded-lg text-center shadow-inner">
                <span class="block text-white/70 text-xs font-bold uppercase mb-1">Status</span>
                <span class="block {{ $employee->is_active ? 'text-green-400' : 'text-red-400' }} text-xl font-black">{{ $employee->is_active ? 'Ativo' : 'Inativo' }}</span>
            </div>
        @endif
    </div>

    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500 text-green-400 p-3 rounded-lg mb-4 text-sm font-bold">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-500/20 border border-red-500 text-red-400 p-3 rounded-lg mb-4 text-sm font-bold">
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
                <label class="block text-white/70 text-xs font-bold mb-1 uppercase tracking-wider">Nome Completo</label>
                <input type="text" name="{{ isset($employee) ? 'name' : 'nome' }}" value="{{ old(isset($employee) ? 'name' : 'nome', $employee->name ?? '') }}" required class="w-full bg-white/5 border border-white/10 focus:border-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium">
            </div>
            <div class="flex-1">
                <label class="block text-white/70 text-xs font-bold mb-1 uppercase tracking-wider">CPF</label>
                <input x-data="{ 
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
                       type="text" name="cpf" required placeholder="000.000.000-00" maxlength="14" class="w-full bg-white/5 border border-white/10 focus:border-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium">
            </div>
        </div>

        <!-- Linha 2: E-mail (Apenas Admin/Gerente editam/criam?) O email é obrigatório -->
        <div>
            <label class="block text-white/70 text-xs font-bold mb-1 uppercase tracking-wider">E-mail Profissional</label>
            <input type="email" name="email" value="{{ old('email', $employee->email ?? '') }}" required class="w-full bg-white/5 border border-white/10 focus:border-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium">
        </div>

        <!-- Linha 3: Departamento e Nível de Acesso -->
        <div class="flex flex-col md:flex-row gap-5">
            <div class="flex-1">
                <label class="block text-white/70 text-xs font-bold mb-1 uppercase tracking-wider">Departamento</label>
                <input type="text" name="departamento" value="{{ old('departamento', $employee->departamento ?? '') }}" required class="w-full bg-white/5 border border-white/10 focus:border-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium">
            </div>
            <div class="flex-1">
                <label class="block text-white/70 text-xs font-bold mb-1 uppercase tracking-wider">Nível de Acesso</label>
                <select name="nivel_acesso" required class="w-full bg-brand-brown border border-white/10 focus:border-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium">
                    <option value="Funcionario" {{ old('nivel_acesso', $employee->nivel_acesso ?? '') == 'Funcionario' ? 'selected' : '' }}>Funcionário</option>
                    <option value="Gerente" {{ old('nivel_acesso', $employee->nivel_acesso ?? '') == 'Gerente' ? 'selected' : '' }}>Gerente</option>
                    @if(auth()->user()->nivel_acesso === 'Admin' || (isset($employee) && $employee->nivel_acesso === 'Admin'))
                        <option value="Admin" {{ old('nivel_acesso', $employee->nivel_acesso ?? '') == 'Admin' ? 'selected' : '' }}>Administrador</option>
                    @endif
                </select>
            </div>
        </div>
        
        @if(isset($employee))
            <!-- Linha 4: Status -->
            <div class="flex items-center gap-2 mt-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $employee->is_active) ? 'checked' : '' }} class="w-5 h-5 accent-brand-yellow">
                <label for="is_active" class="text-white/70 font-bold uppercase tracking-wider text-sm cursor-pointer">Usuário Ativo no Sistema</label>
            </div>
        @else
            <div class="bg-brand-yellow/10 border border-brand-yellow/30 p-4 rounded-xl mt-2 text-sm text-brand-yellow font-medium">
                <strong class="block mb-1">Aviso Importante:</strong>
                A matrícula será gerada automaticamente. A senha padrão inicial será <strong>Mudar@123</strong>.
            </div>
        @endif

        <div class="flex justify-start gap-3 mt-4 pt-4 border-t border-white/10">
            <a href="{{ route('employees.index') }}" class="px-6 py-2 rounded-full font-bold text-white hover:bg-white/10 border border-transparent transition-colors">Cancelar</a>
            <button type="submit" class="px-8 py-2 rounded-full font-bold bg-brand-yellow text-brand-brown hover:bg-white shadow-md transition-colors">
                {{ isset($employee) ? 'Salvar Alterações' : 'Cadastrar Funcionário' }}
            </button>
        </div>
    </form>
    
    @if(isset($employee) && auth()->id() !== $employee->id)
        <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="absolute bottom-6 right-6" onsubmit="return confirm('Tem certeza que deseja excluir definitivamente este funcionário?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 rounded-full font-bold bg-red-500/20 text-red-400 hover:bg-red-500 hover:text-white border border-red-500/30 transition-colors text-xs">Excluir Permanentemente</button>
        </form>
    @endif

</section>
@endsection
