@extends('layouts.sge')

@section('title', 'Histórico de Estoque')

@section('content')
<section class="flex-1 bg-brand-brown rounded-3xl p-6 shadow-xl flex flex-col overflow-hidden h-full">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-white text-xl md:text-2xl font-black tracking-wide">HISTÓRICO GERAL DO ESTOQUE</h2>
        
        <div class="flex gap-3 w-full md:w-auto">
            <!-- Filtro Tipo -->
            <form action="{{ route('stock.history') }}" method="GET" class="flex gap-3">
                <select name="type" onchange="this.form.submit()" class="bg-white/10 border-2 border-transparent focus:border-brand-yellow text-white rounded-full px-4 py-2 outline-none">
                    <option value="" class="text-black" {{ request('type') === null ? 'selected' : '' }}>Todas as Movimentações</option>
                    <option value="in" class="text-black" {{ request('type') === 'in' ? 'selected' : '' }}>Apenas Entradas</option>
                    <option value="out" class="text-black" {{ request('type') === 'out' ? 'selected' : '' }}>Apenas Saídas</option>
                </select>
            </form>
        </div>
    </div>
    
    <!-- Tabela -->
    <div class="flex-1 overflow-hidden flex flex-col">
        <div class="bg-brand-yellow text-brand-brown rounded-t-xl px-4 py-3 flex text-xs md:text-sm font-black tracking-wider uppercase mb-1">
            <div class="w-[20%] pl-2">DATA/HORA</div>
            <div class="w-[15%] text-center">TIPO</div>
            <div class="w-[15%] text-center">PRODUTO ID</div>
            <div class="w-[40%]">PRODUTO NOME</div>
            <div class="w-[10%] text-right pr-4">QTD</div>
        </div>
        
        <div class="flex-1 overflow-y-auto custom-scrollbar flex flex-col gap-2 pr-1">
            
            @forelse($movements as $mov)
                @php
                    $isIn = $mov->type === 'in';
                    $bgClass = $isIn ? 'bg-green-500/10 border-green-500 hover:bg-green-500/20' : 'bg-red-500/10 border-red-500 hover:bg-red-500/20';
                    $textClass = $isIn ? 'text-green-400' : 'text-red-400';
                    $arrow = $isIn ? '&rarr; ENTRADA' : '&larr; SAÍDA';
                    $sign = $isIn ? '+' : '-';
                @endphp
                <div class="{{ $bgClass }} border-l-4 transition-colors rounded-r-lg px-4 py-3 flex items-center text-sm text-white font-medium">
                    <div class="w-[20%] pl-2 opacity-70">{{ $mov->created_at->format('d/m/Y H:i') }}</div>
                    <div class="w-[15%] text-center {{ $textClass }} font-bold">{!! $arrow !!}</div>
                    <div class="w-[15%] text-center opacity-70">#{{ str_pad($mov->product_id, 3, '0', STR_PAD_LEFT) }}</div>
                    <div class="w-[40%] font-bold text-brand-yellow truncate pr-2">{{ $mov->product->name ?? 'Desconhecido' }}</div>
                    <div class="w-[10%] text-right {{ $textClass }} font-black text-lg pr-4">{{ $sign }}{{ $mov->quantity_changed }}</div>
                </div>
            @empty
                <div class="text-white/50 text-center py-6">Nenhuma movimentação registrada.</div>
            @endforelse

        </div>
    </div>

    <!-- Paginação -->
    <div class="mt-4 flex justify-center items-center">
        {{ $movements->links() }}
    </div>

</section>
@endsection
