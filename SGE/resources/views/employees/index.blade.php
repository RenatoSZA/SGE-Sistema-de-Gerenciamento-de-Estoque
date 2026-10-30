@extends('layouts.sge')

@section('title', 'Funcionários')

@section('content')
<section aria-labelledby="heading-lista-funcionarios" class="flex-1 bg-brand-brown rounded-3xl p-6 shadow-xl flex flex-col overflow-hidden h-full">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 id="heading-lista-funcionarios" class="text-white text-xl md:text-2xl font-black tracking-wide">FUNCIONÁRIOS</h2>
        
        <div class="flex gap-4 w-full md:w-auto">
            <!-- Pesquisa -->
            <form action="{{ route('employees.index') }}" method="GET" role="search" aria-label="Buscar funcionários" class="relative flex-1 md:w-[300px]">
                <label for="search-employees" class="sr-only">Buscar funcionário por nome ou matrícula</label>
                <input id="search-employees" type="search" name="search" value="{{ request('search') }}" placeholder="Buscar por nome ou matrícula..." class="w-full bg-white/10 border-2 border-transparent focus:border-brand-yellow focus:ring-2 focus:ring-brand-yellow text-white rounded-full px-4 py-2 pl-10 outline-none transition-colors placeholder:text-white/70">
                <svg aria-hidden="true" class="w-5 h-5 text-white/70 absolute left-3 top-2.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </form>
            
            <!-- Botão Novo -->
            <a href="{{ route('employees.create') }}" class="bg-brand-yellow text-brand-brown font-bold px-6 py-2 rounded-full hover:bg-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white transition-colors shadow-md flex items-center gap-2 whitespace-nowrap">
                <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Novo Funcionário</span>
            </a>
        </div>
    </div>

    <!-- Tabela -->
    <div role="table" aria-label="Lista de funcionários cadastrados" class="flex-1 overflow-hidden flex flex-col mt-2">
        <div role="rowgroup">
            <div role="row" class="bg-brand-yellow text-brand-brown rounded-t-xl px-4 py-3 flex text-xs md:text-sm font-black tracking-wider uppercase mb-1">
                <div role="columnheader" class="w-[5%] pl-2" title="Status">ST</div>
                <div role="columnheader" class="w-[30%]">NOME COMPLETO</div>
                <div role="columnheader" class="w-[15%]">MATRÍCULA</div>
                <div role="columnheader" class="w-[20%]">DEPARTAMENTO</div>
                <div role="columnheader" class="w-[20%] text-center">NÍVEL</div>
                <div role="columnheader" class="w-[10%] text-center">AÇÕES</div>
            </div>
        </div>
        
        <div role="rowgroup" class="flex-1 overflow-y-auto custom-scrollbar flex flex-col gap-1 pr-1">
            
            @forelse($employees as $emp)
                @php
                    $initials = strtoupper($emp->initials());
                    
                    $statusColor = $emp->is_active ? 'bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.6)]' : 'bg-red-500 border-2 border-white/80';
                    $textColor = $emp->is_active ? 'text-white' : 'text-white/75';
                    $opacityClass = $emp->is_active ? '' : 'opacity-85 group-hover:opacity-100';

                    $roleBadge = '';
                    if ($emp->nivel_acesso === 'Admin') {
                        $roleBadge = '<span class="bg-purple-500/20 text-purple-200 px-3 py-1 rounded-full text-xs font-bold border border-purple-400/40">Admin</span>';
                    } elseif ($emp->nivel_acesso === 'Gerente') {
                        $roleBadge = '<span class="bg-blue-500/20 text-blue-200 px-3 py-1 rounded-full text-xs font-bold border border-blue-400/40">Gerente</span>';
                    } else {
                        $roleBadge = '<span class="bg-white/10 text-white/85 px-3 py-1 rounded-full text-xs font-bold border border-white/20">Funcionário</span>';
                    }
                @endphp

                <div role="row" class="bg-white/5 hover:bg-white/10 transition-colors rounded-lg px-4 py-3 flex items-center text-sm {{ $textColor }} font-medium group border border-transparent hover:border-white/20">
                    <div role="cell" class="w-[5%] pl-2 flex items-center">
                        <div class="w-3.5 h-3.5 rounded-full {{ $statusColor }}" title="{{ $emp->is_active ? 'Ativo' : 'Inativo' }}">
                            <span class="sr-only">{{ $emp->is_active ? 'Ativo' : 'Inativo' }}</span>
                        </div>
                    </div>
                    <div role="cell" class="w-[30%] font-bold flex items-center gap-3 pr-2 {{ $emp->nivel_acesso === 'Admin' ? 'text-brand-yellow' : '' }}">
                        <div aria-hidden="true" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-xs border border-white/20 {{ $emp->nivel_acesso === 'Admin' ? 'bg-brand-yellow/20 text-brand-yellow border-brand-yellow/30' : '' }}">{{ $initials }}</div>
                        <span class="truncate">{{ $emp->name }}</span>
                    </div>
                    <div role="cell" class="w-[15%] {{ $emp->is_active ? 'opacity-85' : '' }} truncate">{{ $emp->matricula }}</div>
                    <div role="cell" class="w-[20%] truncate pr-2">{{ $emp->departamento }}</div>
                    <div role="cell" class="w-[20%] text-center">
                        {!! $roleBadge !!}
                    </div>
                    <div role="cell" class="w-[10%] flex justify-center gap-2">
                        <a href="{{ route('employees.edit', $emp) }}" aria-label="Gerenciar funcionário {{ $emp->name }}" class="p-1.5 bg-brand-yellow/20 text-brand-yellow rounded hover:bg-brand-yellow hover:text-brand-brown focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow transition-colors {{ $opacityClass }}" title="Gerenciar {{ $emp->name }}">
                            <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center opacity-75 m-auto mt-10">
                    <svg aria-hidden="true" class="w-16 h-16 text-white mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <p class="text-white text-center text-lg font-bold">Nenhum funcionário encontrado.</p>
                </div>
            @endforelse

        </div>
    </div>
    
    <!-- Paginação -->
    <div class="mt-4 flex justify-center items-center">
        {{ $employees->links() }}
    </div>
    
</section>
@endsection
