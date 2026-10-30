@extends('layouts.sge')

@section('title', 'Histórico de Estoque')

@section('content')
<section aria-labelledby="heading-historico-estoque" class="flex-1 bg-brand-brown rounded-3xl p-6 shadow-xl flex flex-col overflow-hidden h-full">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 id="heading-historico-estoque" class="text-white text-xl md:text-2xl font-black tracking-wide">HISTÓRICO GERAL DO ESTOQUE</h2>
        
        <div class="flex gap-3 w-full md:w-auto">
            <!-- Filtro Tipo -->
            <form action="{{ route('stock.history') }}" method="GET" class="flex items-center gap-2">
                <label for="history-type-filter" class="sr-only">Filtrar movimentações por tipo</label>
                <select id="history-type-filter" name="type" class="bg-white/10 border-2 border-transparent focus:border-brand-yellow focus:ring-2 focus:ring-brand-yellow text-white rounded-full px-4 py-2 outline-none cursor-pointer">
                    <option value="" class="text-black" {{ request('type') === null ? 'selected' : '' }}>Todas as Movimentações</option>
                    <option value="in" class="text-black" {{ request('type') === 'in' ? 'selected' : '' }}>Apenas Entradas</option>
                    <option value="out" class="text-black" {{ request('type') === 'out' ? 'selected' : '' }}>Apenas Saídas</option>
                </select>
                <button type="submit" class="bg-brand-yellow text-brand-brown font-bold px-4 py-2 rounded-full hover:bg-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white transition-colors text-sm">
                    Filtrar
                </button>
            </form>
        </div>
    </div>
    
    <!-- Tabela -->
    <div role="table" aria-label="Tabela de histórico geral do estoque" class="flex-1 overflow-hidden flex flex-col">
        <div role="rowgroup">
            <div role="row" class="bg-brand-yellow text-brand-brown rounded-t-xl px-4 py-3 flex text-xs md:text-sm font-black tracking-wider uppercase mb-1">
                <div role="columnheader" class="w-[20%] pl-2">DATA/HORA</div>
                <div role="columnheader" class="w-[15%] text-center">TIPO</div>
                <div role="columnheader" class="w-[15%] text-center">PRODUTO ID</div>
                <div role="columnheader" class="w-[40%]">PRODUTO NOME</div>
                <div role="columnheader" class="w-[10%] text-right pr-4">QTD</div>
            </div>
        </div>
        
        <div role="rowgroup" class="flex-1 overflow-y-auto custom-scrollbar flex flex-col gap-2 pr-1">
            
            @forelse($movements as $mov)
                @php
                    $isIn = $mov->type === 'in';
                    $bgClass = $isIn ? 'bg-green-500/10 border-green-500 hover:bg-green-500/20' : 'bg-red-500/10 border-red-500 hover:bg-red-500/20';
                    $textClass = $isIn ? 'text-green-300' : 'text-red-300';
                    $arrow = $isIn ? '&rarr;' : '&larr;';
                    $typeLabel = $isIn ? 'ENTRADA' : 'SAÍDA';
                    $sign = $isIn ? '+' : '-';
                @endphp
                <div role="row" class="{{ $bgClass }} border-l-4 transition-colors rounded-r-lg px-4 py-3 flex items-center text-sm text-white font-medium">
                    <div role="cell" class="w-[20%] pl-2 opacity-85">{{ $mov->created_at->format('d/m/Y H:i') }}</div>
                    <div role="cell" class="w-[15%] text-center {{ $textClass }} font-bold">
                        <span aria-hidden="true">{!! $arrow !!}</span> {{ $typeLabel }}
                    </div>
                    <div role="cell" class="w-[15%] text-center opacity-85">#{{ str_pad($mov->product_id, 3, '0', STR_PAD_LEFT) }}</div>
                    <div role="cell" class="w-[40%] font-bold text-brand-yellow truncate pr-2">{{ $mov->product->name ?? 'Desconhecido' }}</div>
                    <div role="cell" class="w-[10%] text-right {{ $textClass }} font-black text-lg pr-4">{{ $sign }}{{ $mov->quantity_changed }}</div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center opacity-75 m-auto mt-10">
                    <svg aria-hidden="true" class="w-16 h-16 text-white mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-white text-center text-lg font-bold">Nenhuma movimentação registrada.</p>
                </div>
            @endforelse

        </div>
    </div>

    <!-- Paginação -->
    <div class="mt-4 flex justify-center items-center">
        {{ $movements->links() }}
    </div>

</section>
@endsection
