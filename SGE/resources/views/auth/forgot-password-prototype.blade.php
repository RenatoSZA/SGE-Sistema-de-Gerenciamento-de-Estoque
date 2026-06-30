<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGE - Recuperação de Senha</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-brand-yellow min-h-screen flex items-center justify-center antialiased p-6 relative overflow-hidden">
    
    <!-- Elemento decorativo de fundo -->
    <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] bg-brand-brown/5 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-[20%] -right-[10%] w-[60%] h-[60%] bg-brand-brown/10 rounded-full blur-3xl"></div>

    <div class="w-full max-w-[450px] relative z-10">
        
        <!-- Logo -->
        <div class="text-center mb-8">
            <h1 class="text-brand-brown text-5xl font-black tracking-widest drop-shadow-sm">SGE</h1>
            <p class="text-brand-brown/70 font-bold mt-2 tracking-wide uppercase text-sm">Sistema de Gerenciamento de Estoque</p>
        </div>

        <!-- Card Formulario -->
        <div class="bg-brand-brown rounded-3xl p-8 shadow-2xl relative overflow-hidden">
            
            <!-- Detalhe visual topo card -->
            <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-brand-yellow/50 via-brand-yellow to-brand-yellow/50"></div>

            <div class="text-center mb-8 mt-2">
                <div class="w-16 h-16 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-4 border border-white/10 shadow-inner">
                    <svg class="w-8 h-8 text-brand-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                </div>
                <h2 class="text-white text-2xl font-black tracking-wide">RECUPERAR ACESSO</h2>
                <p class="text-white/60 text-sm mt-2 font-medium">Esqueceu sua senha? Não tem problema. Informe seus dados abaixo e enviaremos instruções.</p>
            </div>

            <form class="flex flex-col gap-5">
                
                <div>
                    <label class="block text-white/70 text-xs font-bold mb-2 uppercase tracking-wider">Matrícula</label>
                    <div class="relative">
                        <input type="text" placeholder="Ex: F20260001" class="w-full bg-white/5 border border-white/10 focus:border-brand-yellow focus:bg-white/10 text-white rounded-xl px-4 py-3 pl-11 outline-none transition-all font-medium placeholder:text-white/30">
                        <svg class="w-5 h-5 text-white/40 absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                    </div>
                </div>

                <div>
                    <label class="block text-white/70 text-xs font-bold mb-2 uppercase tracking-wider">Email Cadastrado</label>
                    <div class="relative">
                        <input type="email" placeholder="seu@email.com.br" class="w-full bg-white/5 border border-white/10 focus:border-brand-yellow focus:bg-white/10 text-white rounded-xl px-4 py-3 pl-11 outline-none transition-all font-medium placeholder:text-white/30">
                        <svg class="w-5 h-5 text-white/40 absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="button" class="w-full bg-brand-yellow text-brand-brown font-black tracking-wide uppercase py-3.5 rounded-xl hover:bg-white hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                        Enviar Link de Recuperação
                    </button>
                </div>
            </form>

        </div>
        
        <div class="text-center mt-8">
            <a href="#" class="text-brand-brown font-bold text-sm hover:underline hover:text-black transition-colors flex items-center justify-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Voltar para o Login
            </a>
        </div>

    </div>

</body>
</html>
