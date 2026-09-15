@extends('layouts.sge')

@section('title', 'Dashboard')

@section('content')
<div class="flex-1 flex flex-col lg:flex-row gap-6 h-auto lg:h-full overflow-y-auto lg:overflow-hidden custom-scrollbar pr-1 lg:pr-0">
    
    <!-- ENTRADAS E SAÍDAS RECENTES -->
    <section class="flex-1 bg-brand-brown rounded-3xl p-6 shadow-xl flex flex-col overflow-hidden h-auto lg:h-full">
        <h2 class="text-white text-lg md:text-xl font-bold mb-6 text-center tracking-wide">ENTRADAS E SAÍDAS RECENTES</h2>
        
        <div class="flex flex-col gap-3 overflow-y-auto pr-2 custom-scrollbar flex-1">
            @forelse($movements as $mov)
                @php
                    $isOut = $mov->type === 'out';
                    $bgColor = $isOut ? 'bg-red-500/80' : 'bg-green-500/80';
                    $iconArrow = $isOut ? '&larr;' : '&rarr;';
                @endphp
                <div class="flex items-center justify-between {{$bgColor}} hover:opacity-90 transition-opacity cursor-default rounded-full px-4 py-2 shadow-sm text-white text-xs font-bold w-full">
                    <div class="flex items-center gap-3 truncate w-[15%]">
                        <span>{!! $iconArrow !!}</span>
                        <span class="opacity-80 font-normal">#{{$mov->product->id}}</span>
                    </div>
                    <div class="truncate text-center w-[40%] px-2">
                        {{ strtoupper($mov->product->name) }}
                    </div>
                    <div class="truncate text-center w-[30%] px-2 border-l border-white/20">
                        {{ strtoupper($mov->product->brand . '/' . $mov->product->sector) }}
                    </div>
                    <div class="w-[15%] text-right border-l border-white/20 pl-2">
                        #{{ $mov->quantity_changed }}
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center opacity-50 m-auto">
                    <svg class="w-12 h-12 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 12H4M8 16l-4-4 4-4"></path></svg>
                    <p class="text-white text-center text-sm">Nenhuma movimentação recente.</p>
                </div>
            @endforelse
        </div>
    </section>
    
    <!-- RIGHT COLUMN (Funcionários & Alertas) -->
    <div class="flex-1 flex flex-col gap-6 h-auto lg:h-full overflow-hidden">
        
        <!-- FUNCIONÁRIOS -->
        <section class="flex-1 bg-brand-brown rounded-3xl p-6 shadow-xl flex flex-col overflow-hidden min-h-[300px] lg:min-h-[50%]">
            <h2 class="text-white text-lg md:text-xl font-bold mb-4 text-center tracking-wide">FUNCIONÁRIOS</h2>
            
            <div class="flex items-center gap-2 mb-2 px-2">
                <div class="bg-brand-yellow px-2 py-1 rounded text-brand-brown text-[10px] font-black w-14 text-center">ATIVO</div>
                <div class="bg-brand-yellow px-4 py-1 rounded text-brand-brown text-[10px] font-black flex-1 text-center">NOME</div>
                <div class="bg-brand-yellow px-4 py-1 rounded text-brand-brown text-[10px] font-black w-32 text-center">ENTRADA / SAÍDA</div>
            </div>
            
            <div class="flex flex-col gap-2 overflow-y-auto pr-2 custom-scrollbar flex-1">
                @forelse($employees as $emp)
                    <div class="flex items-center gap-2 hover:bg-white/5 p-1 rounded transition-colors cursor-default">
                        <!-- Status dot -->
                        <div class="w-14 flex justify-center">
                            <div class="w-4 h-4 rounded-full {{ $emp->is_active ? 'bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.6)]' : 'bg-red-500 shadow-[0_0_8px_rgba(239,68,68,0.6)]' }}"></div>
                        </div>
                        <!-- Name -->
                        <div class="flex-1 bg-brand-light-brown/60 text-brand-brown font-bold text-xs px-3 py-2 rounded-sm truncate">
                            {{ strtoupper($emp->name) }}
                        </div>
                        <!-- Schedule -->
                        <div class="w-32 bg-brand-light-brown/60 text-brand-brown font-bold text-[10px] px-2 py-2 rounded-sm text-center flex justify-center items-center gap-1">
                            <span class="text-green-800">{{ substr($emp->horario_entrada, 0, 5) }}</span>
                            <span>/</span>
                            <span class="text-red-800">{{ substr($emp->horario_saida, 0, 5) }}</span>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center opacity-50 m-auto">
                        <svg class="w-10 h-10 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"></path></svg>
                        <p class="text-white text-center text-sm">Nenhum funcionário com horário definido.</p>
                    </div>
                @endforelse
            </div>
        </section>
        
        <!-- QUADRO DE AVISOS -->
        <section class="flex-1 bg-brand-brown rounded-3xl p-6 shadow-xl flex flex-col overflow-hidden min-h-[300px] lg:min-h-[40%]">
            <h2 class="text-white text-lg md:text-xl font-bold mb-4 text-center tracking-wide">QUADRO DE AVISOS</h2>
            <div class="flex flex-col gap-3 overflow-y-auto pr-2 custom-scrollbar flex-1">
                @forelse($alerts as $alert)
                    <div class="bg-brand-light-brown/40 border-l-4 {{ $alert->type === 'danger' ? 'border-red-500' : ($alert->type === 'warning' ? 'border-yellow-500' : 'border-blue-500') }} p-3 rounded-r text-white text-sm flex justify-between items-start gap-2 group hover:bg-brand-light-brown/60 transition-colors">
                        <span class="flex-1">{{ $alert->message }}</span>
                        @if(auth()->user()->nivel_acesso === 'Admin' || auth()->user()->nivel_acesso === 'Gerente')
                            <form action="{{ route('alerts.destroy', $alert) }}" method="POST" onsubmit="return confirm('Excluir este aviso?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-white/30 hover:text-red-400 opacity-0 group-hover:opacity-100 transition-all" title="Excluir">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </form>
                        @endif
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center opacity-50 m-auto">
                        <svg class="w-10 h-10 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        <p class="text-white text-center text-sm">Nenhum aviso no momento.</p>
                    </div>
                @endforelse
            </div>
            
            @if(auth()->user()->nivel_acesso === 'Admin' || auth()->user()->nivel_acesso === 'Gerente')
                <form action="{{ route('alerts.store') }}" method="POST" class="mt-4 pt-4 border-t border-white/10 flex gap-2">
                    @csrf
                    <input type="text" name="message" required placeholder="Novo aviso..." maxlength="255" class="flex-1 bg-white/5 border border-white/10 focus:border-brand-yellow text-white rounded-lg px-3 py-2 outline-none text-sm transition-colors">
                    <select name="type" class="bg-brand-brown border border-white/10 focus:border-brand-yellow text-white rounded-lg px-2 py-2 outline-none text-sm cursor-pointer">
                        <option value="info">Info</option>
                        <option value="warning" selected>Atenção</option>
                        <option value="danger">Urgente</option>
                    </select>
                    <button type="submit" class="bg-brand-yellow text-brand-brown font-bold rounded-lg px-4 py-2 hover:bg-white shadow transition-colors text-sm">
                        Postar
                    </button>
                </form>
            @endif
        </section>
        
    </div>
    
</div>
@endsection
