@extends('layouts.sge')

@section('title', 'Dashboard')

@section('content')
<div class="flex-1 flex flex-col md:flex-row gap-6 h-full overflow-hidden w-full">
    
    <!-- ENTRADAS E SAÍDAS RECENTES -->
    <section aria-labelledby="heading-movimentacoes" class="flex-1 bg-brand-brown rounded-3xl p-6 shadow-xl flex flex-col overflow-hidden h-full">
        <h2 id="heading-movimentacoes" class="text-white text-lg md:text-xl font-bold mb-6 text-center tracking-wide">ENTRADAS E SAÍDAS RECENTES</h2>
        
        <div role="list" aria-label="Lista de entradas e saídas recentes" class="flex flex-col gap-3 overflow-y-auto pr-2 custom-scrollbar flex-1">
            @forelse($movements as $mov)
                @php
                    $isOut = $mov->type === 'out';
                    $bgColor = $isOut ? 'bg-red-600/90' : 'bg-green-700/90';
                    $iconArrow = $isOut ? '&larr;' : '&rarr;';
                @endphp
                <div role="listitem" class="flex items-center justify-between {{$bgColor}} hover:opacity-90 transition-opacity cursor-default rounded-full px-4 py-2 shadow-sm text-white text-xs font-bold w-full">
                    <div class="flex items-center gap-3 truncate w-[15%]">
                        <span aria-hidden="true">{!! $iconArrow !!}</span>
                        <span class="sr-only">{{ $isOut ? 'Saída do produto' : 'Entrada do produto' }}</span>
                        <span class="opacity-90 font-normal">#{{$mov->product->id}}</span>
                    </div>
                    <div class="truncate text-center w-[40%] px-2">
                        {{ strtoupper($mov->product->name) }}
                    </div>
                    <div class="truncate text-center w-[30%] px-2 border-l border-white/30">
                        {{ strtoupper($mov->product->brand . '/' . $mov->product->sector) }}
                    </div>
                    <div class="w-[15%] text-right border-l border-white/30 pl-2">
                        <span class="sr-only">Quantidade: </span>{{ $isOut ? '-' : '+' }}{{ $mov->quantity_changed }}
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center opacity-75 m-auto">
                    <svg aria-hidden="true" class="w-12 h-12 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 12H4M8 16l-4-4 4-4"></path></svg>
                    <p class="text-white text-center text-sm">Nenhuma movimentação recente.</p>
                </div>
            @endforelse
        </div>
    </section>
    
    <!-- RIGHT COLUMN (Funcionários & Alertas) -->
    <div class="flex-1 flex flex-col gap-6 h-full overflow-hidden">
        
        <!-- FUNCIONÁRIOS -->
        <section aria-labelledby="heading-funcionarios" class="flex-1 bg-brand-brown rounded-3xl p-6 shadow-xl flex flex-col overflow-hidden min-h-[50%]">
            <h2 id="heading-funcionarios" class="text-white text-lg md:text-xl font-bold mb-4 text-center tracking-wide">FUNCIONÁRIOS</h2>
            
            <div role="table" aria-label="Quadro de horários de funcionários" class="flex-1 flex flex-col overflow-hidden">
                <div role="rowgroup" class=" mb-2 px-2">
                    <div role="row" class="flex items-center gap-2">
                        <div role="columnheader" class="bg-brand-yellow px-2 py-1 rounded text-brand-brown text-xs font-black w-16 text-center">ATIVO</div>
                        <div role="columnheader" class="bg-brand-yellow px-4 py-1 rounded text-brand-brown text-xs font-black flex-1 text-center">NOME</div>
                        <div role="columnheader" class="bg-brand-yellow px-4 py-1 rounded text-brand-brown text-xs font-black w-36 text-center">ENTRADA / SAÍDA</div>
                    </div>
                </div>
                
                <div role="rowgroup" class="flex flex-col gap-2 overflow-y-auto pr-2 custom-scrollbar flex-1">
                    @forelse($employees as $emp)
                        <div role="row" class="flex items-center gap-2 hover:bg-white/5 p-1 rounded transition-colors cursor-default">
                            <!-- Status dot with icon/shape & sr-only text -->
                            <div role="cell" class="w-16 flex justify-center">
                                @if($emp->is_active)
                                    <div class="w-4 h-4 rounded-full bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.6)] flex items-center justify-center" title="Ativo">
                                        <span class="sr-only">Ativo</span>
                                    </div>
                                @else
                                    <div class="w-4 h-4 rounded-full bg-red-500 border-2 border-white/80 shadow-[0_0_8px_rgba(239,68,68,0.6)] flex items-center justify-center" title="Inativo">
                                        <span class="sr-only">Inativo</span>
                                    </div>
                                @endif
                            </div>
                            <!-- Name -->
                            <div role="cell" class="flex-1 bg-brand-light-brown/80 text-brand-brown font-bold text-xs px-3 py-2 rounded-sm truncate">
                                {{ strtoupper($emp->name) }}
                            </div>
                            <!-- Schedule -->
                            <div role="cell" class="w-36 bg-brand-light-brown/80 text-brand-brown font-bold text-xs px-2 py-2 rounded-sm text-center flex justify-center items-center gap-1">
                                <span class="text-green-950"><span class="sr-only">Entrada: </span>{{ substr($emp->horario_entrada, 0, 5) }}</span>
                                <span aria-hidden="true">/</span>
                                <span class="text-red-950"><span class="sr-only">Saída: </span>{{ substr($emp->horario_saida, 0, 5) }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center opacity-75 m-auto">
                            <svg aria-hidden="true" class="w-10 h-10 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"></path></svg>
                            <p class="text-white text-center text-sm">Nenhum funcionário com horário definido.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
        
        <!-- QUADRO DE AVISOS -->
        <section aria-labelledby="heading-avisos" class="flex-1 bg-brand-brown rounded-3xl p-6 shadow-xl flex flex-col overflow-hidden min-h-[40%]">
            <h2 id="heading-avisos" class="text-white text-lg md:text-xl font-bold mb-4 text-center tracking-wide">QUADRO DE AVISOS</h2>
            <div role="list" aria-label="Avisos ativos" class="flex flex-col gap-3 overflow-y-auto pr-2 custom-scrollbar flex-1">
                @forelse($alerts as $alert)
                    @php
                        $alertTypeLabel = $alert->type === 'danger' ? 'Urgente:' : ($alert->type === 'warning' ? 'Atenção:' : 'Informativo:');
                    @endphp
                    <div role="listitem" class="bg-brand-light-brown/40 border-l-4 {{ $alert->type === 'danger' ? 'border-red-500' : ($alert->type === 'warning' ? 'border-yellow-500' : 'border-blue-500') }} p-3 rounded-r text-white text-sm flex justify-between items-start gap-2 group hover:bg-brand-light-brown/60 transition-colors">
                        <span class="flex-1"><span class="sr-only">{{ $alertTypeLabel }} </span>{{ $alert->message }}</span>
                        @if(auth()->user()->nivel_acesso === 'Admin' || auth()->user()->nivel_acesso === 'Gerente')
                            <form action="{{ route('alerts.destroy', $alert) }}" method="POST" onsubmit="return confirm('Excluir este aviso?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" aria-label="Excluir aviso: {{ $alert->message }}" class="text-white/60 hover:text-red-300 focus:text-red-300 opacity-70 group-hover:opacity-100 focus:opacity-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-400 rounded p-1 transition-all" title="Excluir aviso">
                                    <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </form>
                        @endif
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center opacity-75 m-auto">
                        <svg aria-hidden="true" class="w-10 h-10 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        <p class="text-white text-center text-sm">Nenhum aviso no momento.</p>
                    </div>
                @endforelse
            </div>
            
            @if(auth()->user()->nivel_acesso === 'Admin' || auth()->user()->nivel_acesso === 'Gerente')
                <form action="{{ route('alerts.store') }}" method="POST" class="mt-4 pt-4 border-t border-white/10 flex gap-2">
                    @csrf
                    <label for="alert-message" class="sr-only">Mensagem do novo aviso</label>
                    <input id="alert-message" type="text" name="message" required placeholder="Novo aviso..." maxlength="255" class="flex-1 bg-white/5 border border-white/20 focus:border-brand-yellow focus:ring-2 focus:ring-brand-yellow text-white placeholder:text-white/60 rounded-lg px-3 py-2 outline-none text-sm transition-colors">
                    
                    <label for="alert-type" class="sr-only">Prioridade do aviso</label>
                    <select id="alert-type" name="type" class="bg-brand-brown border border-white/20 focus:border-brand-yellow focus:ring-2 focus:ring-brand-yellow text-white rounded-lg px-2 py-2 outline-none text-sm cursor-pointer">
                        <option value="info">Info</option>
                        <option value="warning" selected>Atenção</option>
                        <option value="danger">Urgente</option>
                    </select>
                    <button type="submit" class="bg-brand-yellow text-brand-brown font-bold rounded-lg px-4 py-2 hover:bg-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white shadow transition-colors text-sm">
                        Postar
                    </button>
                </form>
            @endif
        </section>
        
    </div>
    
</div>
@endsection
