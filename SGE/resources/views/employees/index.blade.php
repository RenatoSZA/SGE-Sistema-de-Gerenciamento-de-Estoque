@extends('layouts.sge')

@section('title', 'Funcionários')

@section('content')
<section class="flex-1 bg-brand-brown rounded-3xl p-6 shadow-xl flex flex-col overflow-hidden h-full">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-white text-xl md:text-2xl font-black tracking-wide">FUNCIONÁRIOS</h2>
        
        <div class="flex gap-4 w-full md:w-auto">
            <!-- Pesquisa -->
            <form action="{{ route('employees.index') }}" method="GET" class="relative flex-1 md:w-[300px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nome ou matrícula..." class="w-full bg-white/10 border-2 border-transparent focus:border-brand-yellow text-white rounded-full px-4 py-2 pl-10 outline-none transition-colors placeholder:text-white/50">
                <svg class="w-5 h-5 text-white/50 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </form>
            
            <!-- Botão Novo -->
            <a href="{{ route('employees.create') }}" class="bg-brand-yellow text-brand-brown font-bold px-6 py-2 rounded-full hover:bg-white transition-colors shadow-md flex items-center gap-2 whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Novo
            </a>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500 text-green-400 p-3 rounded-lg mb-4 text-sm font-bold">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- Tabela -->
    <div class="flex-1 overflow-hidden flex flex-col">
        <div class="bg-brand-yellow text-brand-brown rounded-t-xl px-4 py-3 flex text-xs md:text-sm font-black tracking-wider uppercase mb-1">
            <div class="w-[5%] pl-2">ST</div>
            <div class="w-[30%]">NOME COMPLETO</div>
            <div class="w-[15%]">MATRÍCULA</div>
            <div class="w-[20%]">DEPARTAMENTO</div>
            <div class="w-[20%] text-center">NÍVEL</div>
            <div class="w-[10%] text-center">AÇÕES</div>
        </div>
        
        <div class="flex-1 overflow-y-auto custom-scrollbar flex flex-col gap-1 pr-1">
            
            @forelse($employees as $emp)
                @php
                    // Gerar iniciais
                    $words = explode(' ', $emp->name);
                    $initials = '';
                    if (count($words) >= 2) {
                        $initials = strtoupper(substr($words[0], 0, 1) . substr($words[count($words)-1], 0, 1));
                    } else {
                        $initials = strtoupper(substr($words[0], 0, 2));
                    }
                    
                    $statusColor = $emp->is_active ? 'bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.6)]' : 'bg-red-500';
                    $textColor = $emp->is_active ? 'text-white' : 'text-white/50';
                    $opacityClass = $emp->is_active ? '' : 'opacity-70 group-hover:opacity-100';

                    $roleBadge = '';
                    if ($emp->nivel_acesso === 'Admin') {
                        $roleBadge = '<span class="bg-purple-500/20 text-purple-300 px-3 py-1 rounded-full text-xs font-bold border border-purple-500/30">Admin</span>';
                    } elseif ($emp->nivel_acesso === 'Gerente') {
                        $roleBadge = '<span class="bg-blue-500/20 text-blue-300 px-3 py-1 rounded-full text-xs font-bold border border-blue-500/30">Gerente</span>';
                    } else {
                        $roleBadge = '<span class="bg-white/10 text-white/70 px-3 py-1 rounded-full text-xs font-bold border border-white/10">Funcionário</span>';
                    }
                @endphp

                <div class="bg-white/5 hover:bg-white/10 transition-colors rounded-lg px-4 py-3 flex items-center text-sm {{ $textColor }} font-medium group cursor-pointer border border-transparent hover:border-white/20">
                    <div class="w-[5%] pl-2 flex items-center">
                        <div class="w-3 h-3 rounded-full {{ $statusColor }}" title="{{ $emp->is_active ? 'Ativo' : 'Inativo' }}"></div>
                    </div>
                    <div class="w-[30%] font-bold flex items-center gap-3 pr-2 {{ $emp->nivel_acesso === 'Admin' ? 'text-brand-yellow' : '' }}">
                        <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-xs border border-white/20 {{ $emp->nivel_acesso === 'Admin' ? 'bg-brand-yellow/20 text-brand-yellow border-brand-yellow/30' : '' }}">{{ $initials }}</div>
                        <span class="truncate">{{ $emp->name }}</span>
                    </div>
                    <div class="w-[15%] {{ $emp->is_active ? 'opacity-70' : '' }} truncate">{{ $emp->matricula }}</div>
                    <div class="w-[20%] truncate pr-2">{{ $emp->departamento }}</div>
                    <div class="w-[20%] text-center">
                        {!! $roleBadge !!}
                    </div>
                    <div class="w-[10%] flex justify-center gap-2">
                        <a href="{{ route('employees.edit', $emp) }}" class="p-1.5 bg-brand-yellow/20 text-brand-yellow rounded hover:bg-brand-yellow hover:text-brand-brown transition-colors {{ $opacityClass }}" title="Gerenciar">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-white/50 text-center py-6">Nenhum funcionário encontrado.</div>
            @endforelse

        </div>
    </div>
    
    <!-- Paginação -->
    <div class="mt-4 flex justify-center items-center">
        {{ $employees->links() }}
    </div>
    
</section>
@endsection
