@extends('layouts.sge')

@section('title', isset($product) ? 'Gerenciar Produto' : 'Novo Produto')

@section('content')
<div class="flex-1 flex flex-col md:flex-row gap-6 h-full overflow-hidden">
    
    <!-- COLUNA ESQUERDA: Form de Produto -->
    <section class="flex-[3] bg-brand-brown rounded-3xl p-6 shadow-xl flex flex-col overflow-y-auto custom-scrollbar h-full relative">
        
        <!-- Header Secão -->
        <div class="flex justify-between items-start mb-6 border-b border-white/10 pb-4">
            <div>
                <a href="{{ route('products.index') }}" class="text-brand-yellow/80 hover:text-brand-yellow text-sm font-bold flex items-center gap-1 mb-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Voltar para Lista
                </a>
                <h2 class="text-white text-xl md:text-2xl font-black tracking-wide">
                    {{ isset($product) ? 'GERENCIAR PRODUTO #' . str_pad($product->id, 3, '0', STR_PAD_LEFT) : 'NOVO PRODUTO' }}
                </h2>
            </div>
            
            <div class="bg-brand-yellow/10 border border-brand-yellow/30 px-4 py-2 rounded-lg text-center shadow-inner">
                <span class="block text-white/70 text-xs font-bold uppercase mb-1">Estoque Atual</span>
                <span class="block text-brand-yellow text-3xl font-black">{{ isset($product) ? $product->quantity : '0' }}</span>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-500/20 border border-green-500 text-green-400 p-3 rounded-lg mb-4 text-sm font-bold">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-500/20 border border-red-500 text-red-400 p-3 rounded-lg mb-4 text-sm font-bold">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulário de Edição Inline -->
        <form action="{{ isset($product) ? route('products.update', $product) : route('products.store') }}" method="POST" class="flex flex-col gap-5 flex-1">
            @csrf
            @if(isset($product))
                @method('PUT')
            @endif
            
            <!-- Linha 1: Nome -->
            <div>
                <label class="block text-white/70 text-xs font-bold mb-1 uppercase tracking-wider">Nome do Produto</label>
                <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required class="w-full bg-white/5 border border-white/10 focus:border-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium">
            </div>

            <!-- Linha 2: Categoria e Marca -->
            <div class="flex flex-col md:flex-row gap-5">
                <div class="flex-1">
                    <label class="block text-white/70 text-xs font-bold mb-1 uppercase tracking-wider">Categoria</label>
                    <input type="text" name="sector" value="{{ old('sector', $product->sector ?? '') }}" required class="w-full bg-white/5 border border-white/10 focus:border-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium">
                </div>
                <div class="flex-1">
                    <label class="block text-white/70 text-xs font-bold mb-1 uppercase tracking-wider">Marca</label>
                    <input type="text" name="brand" value="{{ old('brand', $product->brand ?? '') }}" required class="w-full bg-white/5 border border-white/10 focus:border-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium">
                </div>
            </div>

            @if(!isset($product))
                <!-- Apenas na criação: Estoque Inicial -->
                <div>
                    <label class="block text-white/70 text-xs font-bold mb-1 uppercase tracking-wider">Estoque Inicial (Opcional)</label>
                    <input type="number" name="quantity" value="{{ old('quantity', 0) }}" min="0" class="w-1/3 bg-white/5 border border-white/10 focus:border-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium">
                </div>
            @endif

            <!-- Ações Form Principal -->
            <div class="flex justify-end gap-3 mt-4 pt-4 border-t border-white/10">
                <a href="{{ route('products.index') }}" class="px-6 py-2 rounded-full font-bold text-white hover:bg-white/10 border border-transparent transition-colors">Cancelar</a>
                <button type="submit" class="px-8 py-2 rounded-full font-bold bg-brand-yellow text-brand-brown hover:bg-white shadow-md transition-colors">
                    {{ isset($product) ? 'Salvar Alterações' : 'Criar Produto' }}
                </button>
            </div>
        </form>

        @if(isset($product))
            <!-- Formulário Exclusão -->
            <form action="{{ route('products.destroy', $product) }}" method="POST" class="absolute bottom-6 left-6" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 rounded-full font-bold bg-red-500/20 text-red-400 hover:bg-red-500 hover:text-white border border-red-500/30 transition-colors text-xs">Excluir Produto</button>
            </form>
            
            <!-- Linha 3: Ajuste de Estoque -->
            <form action="{{ route('products.adjustStock', $product) }}" method="POST" class="bg-white/5 border border-white/10 rounded-xl p-4 mt-8">
                @csrf
                <label class="block text-brand-yellow text-sm font-bold mb-3 uppercase tracking-wider">Ajuste Manual de Estoque</label>
                <div class="flex items-center gap-4">
                    <select name="type" class="bg-brand-brown border border-white/20 text-white rounded-lg px-4 py-2 outline-none focus:border-brand-yellow">
                        <option value="in">Adicionar (+)</option>
                        <option value="out">Remover (-)</option>
                    </select>
                    <input type="number" name="quantity" required min="1" placeholder="Qtd" class="w-24 bg-brand-brown border border-white/20 focus:border-brand-yellow text-white rounded-lg px-4 py-2 outline-none transition-colors">
                    <button type="submit" class="bg-brand-yellow text-brand-brown font-bold px-4 py-2 rounded-lg hover:bg-white transition-colors">Ajustar</button>
                </div>
            </form>
        @endif

    </section>
    
    <!-- COLUNA DIREITA: Histórico Individual -->
    <section class="flex-[2] bg-brand-brown rounded-3xl p-6 shadow-xl flex flex-col overflow-hidden h-full">
        
        <h2 class="text-white text-lg md:text-xl font-bold mb-6 text-center tracking-wide">HISTÓRICO DO PRODUTO</h2>
        
        <div class="flex flex-col gap-3 overflow-y-auto pr-2 custom-scrollbar flex-1">
            
            @if(isset($movements) && $movements->count() > 0)
                @foreach($movements as $mov)
                    @php
                        $isIn = $mov->type === 'in';
                    @endphp
                    <div class="flex flex-col {{ $isIn ? 'bg-green-500/20 border-green-500/30' : 'bg-red-500/20 border-red-500/30' }} border rounded-xl p-3 shadow-sm w-full">
                        <div class="flex justify-between items-center mb-1">
                            <div class="flex items-center gap-2 {{ $isIn ? 'text-green-400' : 'text-red-400' }} font-bold text-sm">
                                <span>{!! $isIn ? '&rarr;' : '&larr;' !!}</span> {{ $isIn ? 'ENTRADA' : 'SAÍDA' }}
                            </div>
                            <span class="text-white/50 text-xs">{{ $mov->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-white text-sm">
                            <span class="opacity-80">Ajuste de Estoque</span>
                            <span class="font-black {{ $isIn ? 'text-green-400' : 'text-red-400' }} text-base">{{ $isIn ? '+' : '-' }}{{ $mov->quantity_changed }}</span>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-white/50 text-center mt-10">Nenhum histórico para este produto ainda.</p>
            @endif

        </div>
    </section>
    
</div>
@endsection
