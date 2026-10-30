@extends('layouts.sge')

@section('title', 'Produtos')

@section('content')
<section aria-labelledby="heading-produtos" class="flex-1 bg-brand-brown rounded-3xl p-6 shadow-xl flex flex-col overflow-hidden h-full">
    
    <!-- Header Interno -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 id="heading-produtos" class="text-white text-xl md:text-2xl font-black tracking-wide">PRODUTOS EM ESTOQUE</h2>
        
        <div class="flex gap-4 w-full md:w-auto">
            <!-- Pesquisa -->
            <form action="{{ route('products.index') }}" method="GET" role="search" aria-label="Buscar produtos" class="relative flex-1 md:w-[300px]">
                <label for="search-products" class="sr-only">Buscar produto por nome, marca ou categoria</label>
                <input id="search-products" type="search" name="search" value="{{ request('search') }}" placeholder="Buscar produto..." class="w-full bg-white/10 border-2 border-transparent focus:border-brand-yellow focus:ring-2 focus:ring-brand-yellow text-white rounded-full px-4 py-2 pl-10 outline-none transition-colors placeholder:text-white/70">
                <svg aria-hidden="true" class="w-5 h-5 text-white/70 absolute left-3 top-2.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </form>
            
            @if(auth()->user()->nivel_acesso === 'Admin' || auth()->user()->nivel_acesso === 'Gerente')
                <!-- Botão Novo Produto (Apenas Admin/Gerente) -->
                <a href="{{ route('products.create') }}" class="bg-brand-yellow text-brand-brown font-bold px-6 py-2 rounded-full hover:bg-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white transition-colors shadow-md flex items-center gap-2 whitespace-nowrap">
                    <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Novo Produto</span>
                </a>
            @endif
        </div>
    </div>
    
    <!-- Tabela de Produtos -->
    <div role="table" aria-label="Tabela de produtos em estoque" class="flex-1 overflow-hidden flex flex-col">
        <!-- Cabeçalho Tabela (Alinhado com as células de dados) -->
        <div role="rowgroup">
            <div role="row" class="bg-brand-yellow text-brand-brown rounded-t-xl px-2 py-3 flex items-center gap-2 text-xs md:text-sm font-black tracking-wider uppercase mb-1">
                <div role="columnheader" class="w-16 text-center">ESTOQUE</div>
                <div role="columnheader" class="flex-1 px-2">NOME</div>
                <div role="columnheader" class="w-1/4 px-2 hidden md:block">MARCA</div>
                <div role="columnheader" class="w-1/4 px-2 hidden md:block">CATEGORIA</div>
                <div role="columnheader" class="w-32 text-right pr-2">AÇÕES</div>
            </div>
        </div>
        
        <!-- Corpo Tabela -->
        <!-- Loop de Produtos -->
        <div role="rowgroup" class="flex flex-col gap-2 overflow-y-auto pr-2 custom-scrollbar flex-1">
            @forelse($products as $product)
                <div role="row" class="flex items-center gap-2 hover:bg-white/5 p-1 rounded-lg transition-colors cursor-default">
                    
                    <!-- Quantidade (com alerta visual e semântico) -->
                    <div role="cell" class="w-16 flex justify-center">
                        @if($product->quantity <= $product->min_quantity)
                            <div class="bg-red-600 text-white font-bold text-xs w-full py-1 rounded text-center shadow-[0_0_8px_rgba(239,68,68,0.6)] motion-safe:animate-pulse" title="Estoque Baixo">
                                <span class="sr-only">Estoque baixo: </span>{{ $product->quantity }}
                            </div>
                        @else
                            <div class="bg-brand-light-brown/80 text-brand-brown font-bold text-xs w-full py-1 rounded text-center">
                                {{ $product->quantity }}
                            </div>
                        @endif
                    </div>
                    
                    <!-- Nome -->
                    <div role="cell" class="flex-1 bg-brand-light-brown/80 text-brand-brown font-bold text-xs px-3 py-2 rounded-sm truncate">
                        {{ strtoupper($product->name) }}
                    </div>
                    
                    <!-- Marca -->
                    <div role="cell" class="w-1/4 bg-brand-light-brown/80 text-brand-brown font-bold text-xs px-3 py-2 rounded-sm truncate hidden md:block">
                        {{ strtoupper($product->brand) }}
                    </div>

                    <!-- Setor / Categoria -->
                    <div role="cell" class="w-1/4 bg-brand-light-brown/80 text-brand-brown font-bold text-xs px-3 py-2 rounded-sm truncate hidden md:block">
                        {{ strtoupper($product->sector) }}
                    </div>

                    <!-- Ações -->
                    <div role="cell" class="w-32 flex gap-1 justify-end pr-1">
                        @if(auth()->user()->nivel_acesso === 'Admin' || auth()->user()->nivel_acesso === 'Gerente')
                            <!-- Editar -->
                            <a href="{{ route('products.edit', $product->id) }}" aria-label="Editar produto {{ $product->name }}" class="p-1.5 bg-brand-yellow text-brand-brown rounded hover:bg-white hover:text-brand-brown focus:outline-none focus-visible:ring-2 focus-visible:ring-white transition-colors shadow-sm" title="Editar produto {{ $product->name }}">
                                <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                        @endif
                        
                        <!-- Ajustar Estoque (Modal) -->
                        <button type="button" x-data x-on:click="$dispatch('open-stock-modal', { id: {{ $product->id }}, name: @js($product->name), current: {{ $product->quantity }} })" aria-label="Ajustar estoque de {{ $product->name }}" class="p-1.5 bg-white/10 text-white rounded hover:bg-brand-yellow hover:text-brand-brown focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow transition-colors shadow-sm" title="Ajustar estoque de {{ $product->name }}">
                            <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                        </button>
                    </div>
                    
                </div>
            @empty
                <div class="flex flex-col items-center justify-center opacity-75 m-auto mt-10">
                    <svg aria-hidden="true" class="w-16 h-16 text-white mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <p class="text-white text-center text-lg font-bold">Nenhum produto cadastrado.</p>
                    <p class="text-white/80 text-center text-sm mt-1">Clique no botão "Novo Produto" acima para adicionar um novo.</p>
                </div>
            @endforelse
        </div>
    </div>
    
    <!-- Paginação -->
    <div class="mt-4 flex justify-center items-center">
        {{ $products->links() }}
    </div>

</section>

<!-- Modal de Ajuste Rápido de Estoque -->
<div x-data="{
        open: false,
        productId: null,
        productName: '',
        currentStock: 0,
        type: 'in',
        quantity: 1,
        init() {
            window.addEventListener('open-stock-modal', (e) => {
                const data = e.detail;
                if (typeof data === 'object' && data !== null) {
                    this.productId = data.id;
                    this.productName = data.name;
                    this.currentStock = data.current;
                } else {
                    this.productId = data;
                    this.productName = '';
                    this.currentStock = 0;
                }
                this.type = 'in';
                this.quantity = 1;
                this.open = true;
            });
        }
     }"
     x-show="open"
     x-on:keydown.escape.window="open = false"
     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
     style="display: none;"
     role="dialog"
     aria-modal="true"
     aria-labelledby="stock-modal-title">
    
    <div x-show="open"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         @click.away="open = false"
         class="bg-brand-brown border border-white/20 rounded-3xl p-6 w-full max-w-md shadow-2xl">
        
        <div class="flex justify-between items-center mb-4 border-b border-white/10 pb-3">
            <h3 id="stock-modal-title" class="text-white text-lg font-black tracking-wide uppercase">
                Ajustar Estoque
            </h3>
            <button type="button" @click="open = false" aria-label="Fechar" class="text-white/60 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <p class="text-white/80 text-sm mb-4">
            Produto: <strong class="text-brand-yellow" x-text="productName ? productName : ('#' + productId)"></strong>
            <span class="block text-xs text-white/60 mt-1">
                Saldo atual em estoque: <span class="font-bold text-white" x-text="currentStock"></span> un.
            </span>
        </p>

        <form :action="'{{ url('products') }}/' + productId + '/adjust-stock'" method="POST" class="flex flex-col gap-4">
            @csrf
            <div>
                <label class="block text-white/80 text-xs font-bold mb-1 uppercase tracking-wider">Tipo de Movimentação</label>
                <select name="type" x-model="type" class="w-full bg-brand-brown border border-white/20 focus:border-brand-yellow focus:ring-2 focus:ring-brand-yellow text-white rounded-lg px-3 py-2 outline-none text-sm font-bold cursor-pointer">
                    <option value="in">Entrada (+ Adicionar)</option>
                    <option value="out">Saída (- Remover)</option>
                </select>
            </div>

            <div>
                <label class="block text-white/80 text-xs font-bold mb-1 uppercase tracking-wider">Quantidade</label>
                <input type="number" name="quantity" x-model="quantity" required min="1" class="w-full bg-white/5 border border-white/20 focus:border-brand-yellow focus:ring-2 focus:ring-brand-yellow text-white rounded-lg px-3 py-2 outline-none text-sm font-bold">
            </div>

            <div>
                <label class="block text-white/80 text-xs font-bold mb-1 uppercase tracking-wider">Observação / Justificativa (Opcional)</label>
                <input type="text" name="notes" maxlength="255" placeholder="Ex: Reposição de fornecedor, uso interno..." class="w-full bg-white/5 border border-white/20 focus:border-brand-yellow focus:ring-2 focus:ring-brand-yellow text-white placeholder:text-white/50 rounded-lg px-3 py-2 outline-none text-sm font-medium">
            </div>

            <div class="flex justify-end gap-3 mt-4 pt-3 border-t border-white/10">
                <button type="button" @click="open = false" class="px-5 py-2 rounded-full font-bold text-white hover:bg-white/10 transition-colors text-sm">
                    Cancelar
                </button>
                <button type="submit" class="px-6 py-2 rounded-full font-bold bg-brand-yellow text-brand-brown hover:bg-white shadow transition-colors text-sm">
                    Confirmar Ajuste
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
