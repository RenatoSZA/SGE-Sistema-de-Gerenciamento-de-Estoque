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
        <div class="flex-1 overflow-y-auto custom-scrollbar flex flex-col gap-1 pr-1">
            
            @forelse($products as $product)
                <div class="bg-white/5 hover:bg-white/10 transition-colors rounded-lg px-4 py-3 flex items-center text-sm text-white font-medium group border border-transparent hover:border-white/20">
                    <div class="w-[10%] pl-2 opacity-70">#{{ str_pad($product->id, 3, '0', STR_PAD_LEFT) }}</div>
                    <div class="w-[30%] font-bold text-brand-yellow truncate pr-2">{{ $product->name }}</div>
                    <div class="w-[20%] truncate pr-2">{{ $product->sector }}</div>
                    <div class="w-[20%] truncate pr-2">{{ $product->brand }}</div>
                    <div class="w-[10%] text-center">
                        @if($product->quantity <= 5)
                            <span class="bg-red-500/20 text-red-400 px-3 py-1 rounded-full text-xs font-bold border border-red-500/30">{{ $product->quantity }}</span>
                        @else
                            <span class="bg-white/10 px-3 py-1 rounded-full text-xs font-bold">{{ $product->quantity }}</span>
                        @endif
                    </div>
                    <div class="w-[10%] flex justify-center gap-2">
                        <a href="{{ route('products.edit', $product) }}" class="p-1.5 bg-brand-yellow/20 text-brand-yellow rounded hover:bg-brand-yellow hover:text-brand-brown transition-colors" title="Gerenciar">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-white/50 text-center py-6">Nenhum produto encontrado.</div>
            @endforelse
            
        </div>
    </div>
    
    <!-- Paginação -->
    <div class="mt-4 flex justify-center items-center">
        {{ $products->links() }}
    </div>

</section>
@endsection
