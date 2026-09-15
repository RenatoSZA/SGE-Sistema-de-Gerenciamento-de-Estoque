@extends('layouts.sge')

@section('title', 'Produtos')

@section('content')
<section class="flex-1 bg-brand-brown rounded-3xl p-6 shadow-xl flex flex-col overflow-hidden h-full">
    
    <!-- Header Interno -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-white text-xl md:text-2xl font-black tracking-wide">PRODUTOS EM ESTOQUE</h2>
        
        <div class="flex gap-4 w-full md:w-auto">
            <!-- Pesquisa -->
            <form action="{{ route('products.index') }}" method="GET" class="relative flex-1 md:w-[300px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar produto..." class="w-full bg-white/10 border-2 border-transparent focus:border-brand-yellow text-white rounded-full px-4 py-2 pl-10 outline-none transition-colors placeholder:text-white/50">
                <svg class="w-5 h-5 text-white/50 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </form>
            
            <!-- Botão Novo Produto -->
            <a href="{{ route('products.create') }}" class="bg-brand-yellow text-brand-brown font-bold px-6 py-2 rounded-full hover:bg-white transition-colors shadow-md flex items-center gap-2 whitespace-nowrap">
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
    
    <!-- Tabela de Produtos -->
    <div class="flex-1 overflow-hidden flex flex-col">
        <!-- Cabeçalho Tabela -->
        <div class="bg-brand-yellow text-brand-brown rounded-t-xl px-4 py-3 flex text-xs md:text-sm font-black tracking-wider uppercase mb-1">
            <div class="w-[10%] pl-2">#ID</div>
            <div class="w-[30%]">NOME</div>
            <div class="w-[20%]">CATEGORIA</div>
            <div class="w-[20%]">MARCA</div>
            <div class="w-[10%] text-center">ESTOQUE</div>
            <div class="w-[10%] text-center">AÇÕES</div>
        </div>
        
        <!-- Corpo Tabela -->
        <!-- Loop de Produtos -->
        <div class="flex flex-col gap-2 overflow-y-auto pr-2 custom-scrollbar flex-1">
            @forelse($products as $product)
                <div class="flex items-center gap-2 hover:bg-white/5 p-1 rounded-lg transition-colors cursor-default">
                    
                    <!-- Quantidade (com alerta visual) -->
                    <div class="w-16 flex justify-center">
                        @if($product->quantity <= $product->min_quantity)
                            <div class="bg-red-500 text-white font-bold text-xs w-full py-1 rounded text-center shadow-[0_0_8px_rgba(239,68,68,0.6)] animate-pulse" title="Estoque Baixo">
                                {{ $product->quantity }}
                            </div>
                        @else
                            <div class="bg-brand-light-brown/60 text-brand-brown font-bold text-xs w-full py-1 rounded text-center">
                                {{ $product->quantity }}
                            </div>
                        @endif
                    </div>
                    
                    <!-- Nome -->
                    <div class="flex-1 bg-brand-light-brown/60 text-brand-brown font-bold text-xs px-3 py-2 rounded-sm truncate">
                        {{ strtoupper($product->name) }}
                    </div>
                    
                    <!-- Marca -->
                    <div class="w-1/4 bg-brand-light-brown/60 text-brand-brown font-bold text-xs px-3 py-2 rounded-sm truncate hidden md:block">
                        {{ strtoupper($product->brand) }}
                    </div>

                    <!-- Setor -->
                    <div class="w-1/4 bg-brand-light-brown/60 text-brand-brown font-bold text-xs px-3 py-2 rounded-sm truncate hidden md:block">
                        {{ strtoupper($product->sector) }}
                    </div>

                    <!-- Ações -->
                    <div class="w-32 flex gap-1 justify-end pr-1">
                        @if(auth()->user()->nivel_acesso === 'Admin' || auth()->user()->nivel_acesso === 'Gerente')
                            <!-- Editar -->
                            <a href="{{ route('products.edit', $product->id) }}" class="p-1.5 bg-brand-yellow text-brand-brown rounded hover:bg-white hover:text-brand-brown transition-colors shadow-sm" title="Editar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                        @endif
                        
                        <!-- Ajustar Estoque (Modal/Opção) - Pode ser acessível por Padrão e Gerente/Admin -->
                        <button x-data x-on:click="$dispatch('open-stock-modal', {{ $product->id }})" class="p-1.5 bg-white/10 text-white rounded hover:bg-brand-yellow hover:text-brand-brown transition-colors shadow-sm" title="Ajustar Estoque">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                        </button>
                    </div>
                    
                </div>
            @empty
                <div class="flex flex-col items-center justify-center opacity-50 m-auto mt-10">
                    <svg class="w-16 h-16 text-white mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <p class="text-white text-center text-lg font-bold">Nenhum produto cadastrado.</p>
                    <p class="text-white/70 text-center text-sm mt-1">Clique no botão acima para adicionar um novo.</p>
                </div>
            @endforelse
        </div>
    </div>
    
    <!-- Paginação -->
    <div class="mt-4 flex justify-center items-center">
        {{ $products->links() }}
    </div>

</section>
@endsection
