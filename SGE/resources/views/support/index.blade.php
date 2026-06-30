@extends('layouts.sge')

@section('title', 'Suporte')

@section('content')
<div class="flex-1 flex flex-col md:flex-row gap-6 h-full overflow-hidden">
    
    <!-- COLUNA ESQUERDA: Abrir Chamado -->
    <section class="flex-1 bg-brand-brown rounded-3xl p-6 shadow-xl flex flex-col overflow-y-auto custom-scrollbar h-full relative">
        
        <div class="mb-6 border-b border-white/10 pb-4">
            <h2 class="text-white text-xl md:text-2xl font-black tracking-wide">PRECISA DE AJUDA?</h2>
            <p class="text-white/60 text-sm mt-1">Abra um chamado direto com nossa equipe de suporte técnico.</p>
        </div>

        <form class="flex flex-col gap-5 flex-1" action="#" method="POST">
            @csrf
            
            <div>
                <label class="block text-white/70 text-xs font-bold mb-1 uppercase tracking-wider">Assunto / Problema</label>
                <select name="subject" class="w-full bg-white/5 border border-white/10 focus:border-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium">
                    <option class="text-black" value="acesso">Dificuldade em acessar a conta</option>
                    <option class="text-black" value="estoque">Erro ao registrar entrada/saída</option>
                    <option class="text-black" value="produto">Problema com cadastro de produto</option>
                    <option class="text-black" value="lentidao">Relatar lentidão no sistema</option>
                    <option class="text-black" value="outros">Outros...</option>
                </select>
            </div>

            <div class="flex-1 flex flex-col">
                <label class="block text-white/70 text-xs font-bold mb-1 uppercase tracking-wider">Descrição detalhada</label>
                <textarea name="description" placeholder="Descreva o que aconteceu, inclua mensagens de erro se houver..." class="w-full flex-1 min-h-[150px] bg-white/5 border border-white/10 focus:border-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium resize-none custom-scrollbar placeholder:text-white/30"></textarea>
            </div>

            <div>
                <label class="block text-white/70 text-xs font-bold mb-1 uppercase tracking-wider">Anexo (Opcional)</label>
                <div class="border-2 border-dashed border-white/20 rounded-xl p-4 flex flex-col items-center justify-center text-center cursor-pointer hover:bg-white/5 transition-colors">
                    <svg class="w-6 h-6 text-white/50 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    <span class="text-white/70 text-sm font-medium">Clique para anexar um print do erro</span>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-4 pt-4 border-t border-white/10">
                <button type="submit" class="px-8 py-3 rounded-full font-bold bg-brand-yellow text-brand-brown hover:bg-white shadow-md transition-colors w-full md:w-auto">Enviar Chamado</button>
            </div>
        </form>

    </section>
    
    <!-- COLUNA DIREITA: FAQ -->
    <section class="flex-1 bg-brand-brown rounded-3xl p-6 shadow-xl flex flex-col overflow-hidden h-full">
        
        <h2 class="text-white text-lg md:text-xl font-bold mb-6 text-center tracking-wide">DÚVIDAS FREQUENTES (FAQ)</h2>
        
        <div class="flex flex-col gap-3 overflow-y-auto pr-2 custom-scrollbar flex-1" x-data="{ open: null }">
            
            <!-- Pergunta 1 -->
            <div class="bg-white/5 border border-white/10 rounded-xl overflow-hidden transition-all">
                <button @click="open === 1 ? open = null : open = 1" class="w-full text-left px-5 py-4 flex justify-between items-center font-bold text-white hover:bg-white/5 transition-colors">
                    <span>Como redefinir minha senha se eu esquecer?</span>
                    <svg class="w-5 h-5 text-brand-yellow transform transition-transform" :class="open === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open === 1" class="px-5 pb-4 text-white/70 text-sm border-t border-white/10 pt-3" style="display: none;">
                    Na tela de login, clique em "Esqueci minha senha". O sistema solicitará sua Matrícula e Email cadastrado. Um link de redefinição será enviado imediatamente para você.
                </div>
            </div>

            <!-- Pergunta 2 -->
            <div class="bg-white/5 border border-white/10 rounded-xl overflow-hidden transition-all">
                <button @click="open === 2 ? open = null : open = 2" class="w-full text-left px-5 py-4 flex justify-between items-center font-bold text-white hover:bg-white/5 transition-colors">
                    <span>Quem pode cadastrar novos funcionários?</span>
                    <svg class="w-5 h-5 text-brand-yellow transform transition-transform" :class="open === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open === 2" class="px-5 pb-4 text-white/70 text-sm border-t border-white/10 pt-3" style="display: none;">
                    Apenas usuários com nível "Gerente" ou "Admin" possuem permissão para acessar a tela de cadastro. Gerentes não podem cadastrar outros Administradores.
                </div>
            </div>

            <!-- Pergunta 3 -->
            <div class="bg-white/5 border border-white/10 rounded-xl overflow-hidden transition-all">
                <button @click="open === 3 ? open = null : open = 3" class="w-full text-left px-5 py-4 flex justify-between items-center font-bold text-white hover:bg-white/5 transition-colors">
                    <span>Fiz uma movimentação errada. Como apagar?</span>
                    <svg class="w-5 h-5 text-brand-yellow transform transition-transform" :class="open === 3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open === 3" class="px-5 pb-4 text-white/70 text-sm border-t border-white/10 pt-3" style="display: none;">
                    Por segurança e auditoria, as movimentações de estoque não podem ser "apagadas". Você deve fazer uma movimentação inversa para corrigir o saldo e adicionar uma observação justificando o erro.
                </div>
            </div>

        </div>
    </section>
    
</div>
@endsection
