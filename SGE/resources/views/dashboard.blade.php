@extends('layouts.sge')

@section('title', 'Dashboard')

@section('content')
<div class="flex-1 flex flex-col md:flex-row gap-6 h-full overflow-hidden">
    
    <!-- ENTRADAS E SAÍDAS RECENTES -->
    <section class="flex-1 bg-brand-brown rounded-3xl p-6 shadow-xl flex flex-col overflow-hidden h-full">
        <h2 class="text-white text-lg md:text-xl font-bold mb-6 text-center tracking-wide">ENTRADAS E SAÍDAS RECENTES</h2>
        
        <div class="flex flex-col gap-3 overflow-y-auto pr-2 custom-scrollbar flex-1">
            @forelse($movements as $mov)
                @php
                    $isOut = $mov->type === 'out';
                    $bgColor = $isOut ? 'bg-red-500/80' : 'bg-green-500/80';
                    $iconArrow = $isOut ? '&larr;' : '&rarr;';
                @endphp
                <div class="flex items-center justify-between {{$bgColor}} rounded-full px-4 py-2 shadow-sm text-white text-xs font-bold w-full">
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
                <p class="text-white/50 text-center text-sm">Nenhuma movimentação recente.</p>
            @endforelse
        </div>
    </section>
    
    <!-- RIGHT COLUMN (Funcionários & Alertas) -->
    <div class="flex-1 flex flex-col gap-6 h-full overflow-hidden">
        
        <!-- FUNCIONÁRIOS -->
        <section class="flex-1 bg-brand-brown rounded-3xl p-6 shadow-xl flex flex-col overflow-hidden min-h-[50%]">
            <h2 class="text-white text-lg md:text-xl font-bold mb-4 text-center tracking-wide">FUNCIONÁRIOS</h2>
            
            <div class="flex items-center gap-2 mb-2 px-2">
                <div class="bg-brand-yellow px-2 py-1 rounded text-brand-brown text-[10px] font-black w-14 text-center">ATIVO</div>
                <div class="bg-brand-yellow px-4 py-1 rounded text-brand-brown text-[10px] font-black flex-1 text-center">NOME DO FUNCIONÁRIO</div>
                <div class="bg-brand-yellow px-4 py-1 rounded text-brand-brown text-[10px] font-black w-32 text-center">ENTRADA E SAÍDA</div>
            </div>
            
            <div class="flex flex-col gap-2 overflow-y-auto pr-2 custom-scrollbar flex-1">
                @foreach($employees as $emp)
                    <div class="flex items-center gap-2">
                        <!-- Status dot -->
                        <div class="w-14 flex justify-center">
                            <div class="w-5 h-5 rounded-full {{ $emp->is_active ? 'bg-green-500' : 'bg-red-500' }}"></div>
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
                @endforeach
            </div>
        </section>
        
        <!-- ALERTAS -->
        <section class="flex-1 bg-brand-brown rounded-3xl p-6 shadow-xl flex flex-col overflow-hidden min-h-[40%]">
            <div class="flex flex-col gap-3 overflow-y-auto pr-2 custom-scrollbar flex-1">
                @forelse($alerts as $alert)
                    <div class="bg-brand-light-brown/40 border-l-4 {{ $alert->type === 'danger' ? 'border-red-500' : ($alert->type === 'warning' ? 'border-yellow-500' : 'border-blue-500') }} p-3 rounded-r text-white text-sm">
                        {{ $alert->message }}
                    </div>
                @empty
                    <p class="text-white/50 text-center text-sm m-auto">Nenhum aviso no momento.</p>
                @endforelse
            </div>
        </section>
        
    </div>
    
</div>
@endsection
