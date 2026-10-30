@extends('layouts.sge')

@section('title', 'Suporte')

@section('content')
<div class="flex-1 flex flex-col md:flex-row gap-6 h-full overflow-hidden w-full">
    
    <!-- COLUNA ESQUERDA: Abrir Chamado -->
    <section aria-labelledby="heading-suporte" class="flex-1 bg-brand-brown rounded-3xl p-6 shadow-xl flex flex-col overflow-y-auto custom-scrollbar h-full relative">
        
        <div class="mb-6 border-b border-white/10 pb-4">
            <h2 id="heading-suporte" class="text-white text-xl md:text-2xl font-black tracking-wide">PRECISA DE AJUDA?</h2>
            <p class="text-white/80 text-sm mt-1">Abra um chamado direto com nossa equipe de suporte técnico.</p>
        </div>

        <form class="flex flex-col gap-5 flex-1" action="{{ route('support.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div>
                <label for="support-subject" class="block text-white/80 text-xs font-bold mb-1 uppercase tracking-wider">Assunto / Problema</label>
                <select id="support-subject" name="subject" class="w-full bg-white/5 border border-white/20 focus:border-brand-yellow focus:ring-2 focus:ring-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium">
                    <option class="text-black" value="acesso">Dificuldade em acessar a conta</option>
                    <option class="text-black" value="estoque">Erro ao registrar entrada/saída</option>
                    <option class="text-black" value="produto">Problema com cadastro de produto</option>
                    <option class="text-black" value="lentidao">Relatar lentidão no sistema</option>
                    <option class="text-black" value="outros">Outros...</option>
                </select>
            </div>

            <div class="flex-1 flex flex-col">
                <label for="support-description" class="block text-white/80 text-xs font-bold mb-1 uppercase tracking-wider">Descrição detalhada</label>
                <textarea id="support-description" name="description" required placeholder="Descreva o que aconteceu, inclua mensagens de erro se houver..." class="w-full flex-1 min-h-[150px] bg-white/5 border border-white/20 focus:border-brand-yellow focus:ring-2 focus:ring-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium resize-none custom-scrollbar placeholder:text-white/60"></textarea>
            </div>

            <div x-data="{ fileName: '' }">
                <span id="attachment-label" class="block text-white/80 text-xs font-bold mb-1 uppercase tracking-wider">Anexo (Opcional)</span>
                <label for="support-attachment" class="border-2 border-dashed border-white/30 rounded-xl p-4 flex flex-col items-center justify-center text-center cursor-pointer hover:bg-white/5 focus-within:ring-2 focus-within:ring-brand-yellow focus-within:border-brand-yellow transition-colors">
                    <input id="support-attachment" type="file" name="attachment" accept="image/*,.pdf" aria-describedby="attachment-label" class="sr-only" @change="fileName = $event.target.files[0]?.name || ''">
                    <svg aria-hidden="true" class="w-6 h-6 text-white/75 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    <span class="text-white/85 text-sm font-medium" x-text="fileName ? 'Arquivo selecionado: ' + fileName : 'Clique ou pressione Enter para anexar um print do erro'">Clique ou pressione Enter para anexar um print do erro</span>
                </label>
            </div>

            <div class="flex justify-end gap-3 mt-4 pt-4 border-t border-white/10">
                <button type="submit" class="px-8 py-3 rounded-full font-bold bg-brand-yellow text-brand-brown hover:bg-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white shadow-md transition-colors w-full md:w-auto">Enviar Chamado</button>
            </div>
        </form>

    </section>
    
    <!-- COLUNA DIREITA: FAQ -->
    <section aria-labelledby="heading-faq" class="flex-1 bg-brand-brown rounded-3xl p-6 shadow-xl flex flex-col overflow-hidden h-full">
        
        <h2 id="heading-faq" class="text-white text-lg md:text-xl font-bold mb-6 text-center tracking-wide">DÚVIDAS FREQUENTES (FAQ)</h2>
        
        <div class="flex flex-col gap-3 overflow-y-auto pr-2 custom-scrollbar flex-1" x-data="{ open: null }">
            
            <!-- Pergunta 1 -->
            <div class="bg-white/5 border border-white/10 rounded-xl overflow-hidden transition-all">
                <h3>
                    <button type="button" id="faq-btn-1" @click="open === 1 ? open = null : open = 1" :aria-expanded="(open === 1).toString()" aria-controls="faq-panel-1" class="w-full text-left px-5 py-4 flex justify-between items-center font-bold text-white hover:bg-white/5 focus:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-brand-yellow transition-colors">
                        <span>Como redefinir minha senha se eu esquecer?</span>
                        <svg aria-hidden="true" class="w-5 h-5 text-brand-yellow transform transition-transform shrink-0 ml-2" :class="open === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </h3>
                <div id="faq-panel-1" role="region" aria-labelledby="faq-btn-1" x-show="open === 1" class="px-5 pb-4 text-white/85 text-sm border-t border-white/10 pt-3" style="display: none;">
                    Na tela de login, clique em "Esqueci minha senha". O sistema solicitará sua Matrícula e Email cadastrado. Um link de redefinição será enviado imediatamente para você.
                </div>
            </div>

            <!-- Pergunta 2 -->
            <div class="bg-white/5 border border-white/10 rounded-xl overflow-hidden transition-all">
                <h3>
                    <button type="button" id="faq-btn-2" @click="open === 2 ? open = null : open = 2" :aria-expanded="(open === 2).toString()" aria-controls="faq-panel-2" class="w-full text-left px-5 py-4 flex justify-between items-center font-bold text-white hover:bg-white/5 focus:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-brand-yellow transition-colors">
                        <span>Quem pode cadastrar novos funcionários?</span>
                        <svg aria-hidden="true" class="w-5 h-5 text-brand-yellow transform transition-transform shrink-0 ml-2" :class="open === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </h3>
                <div id="faq-panel-2" role="region" aria-labelledby="faq-btn-2" x-show="open === 2" class="px-5 pb-4 text-white/85 text-sm border-t border-white/10 pt-3" style="display: none;">
                    Apenas usuários com nível "Gerente" ou "Admin" possuem permissão para acessar a tela de cadastro. Gerentes não podem cadastrar outros Administradores.
                </div>
            </div>

            <!-- Pergunta 3 -->
            <div class="bg-white/5 border border-white/10 rounded-xl overflow-hidden transition-all">
                <h3>
                    <button type="button" id="faq-btn-3" @click="open === 3 ? open = null : open = 3" :aria-expanded="(open === 3).toString()" aria-controls="faq-panel-3" class="w-full text-left px-5 py-4 flex justify-between items-center font-bold text-white hover:bg-white/5 focus:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-brand-yellow transition-colors">
                        <span>Fiz uma movimentação errada. Como apagar?</span>
                        <svg aria-hidden="true" class="w-5 h-5 text-brand-yellow transform transition-transform shrink-0 ml-2" :class="open === 3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </h3>
                <div id="faq-panel-3" role="region" aria-labelledby="faq-btn-3" x-show="open === 3" class="px-5 pb-4 text-white/85 text-sm border-t border-white/10 pt-3" style="display: none;">
                    Por segurança e auditoria, as movimentações de estoque não podem ser "apagadas". Você deve fazer uma movimentação inversa para corrigir o saldo e adicionar uma observação justificando o erro.
                </div>
            </div>

        </div>

        @if(isset($tickets) && $tickets->count() > 0)
            <div class="mt-6 pt-4 border-t border-white/10">
                <h3 class="text-brand-yellow text-sm font-black uppercase tracking-wider mb-3">Chamados Recentes</h3>
                <div class="flex flex-col gap-2 max-h-[180px] overflow-y-auto pr-1 custom-scrollbar">
                    @foreach($tickets as $ticket)
                        <div class="bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-xs text-white flex justify-between items-center gap-2">
                            <div class="truncate">
                                <span class="font-bold text-brand-yellow">[{{ strtoupper($ticket->subject) }}]</span>
                                <span class="opacity-90">{{ $ticket->description }}</span>
                                <span class="text-white/60 ml-1">({{ $ticket->user->name ?? 'Usuário' }})</span>
                            </div>
                            <span class="px-2 py-0.5 rounded-full bg-green-500/20 text-green-300 font-bold shrink-0">{{ ucfirst($ticket->status) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
    
</div>
@endsection
