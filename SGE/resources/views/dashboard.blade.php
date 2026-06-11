<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGE Dashboard</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-brand-yellow min-h-screen flex flex-col overflow-x-hidden antialiased">
    
    <!-- Header -->
    <header class="bg-brand-brown h-[60px] flex justify-center items-center shadow-md relative z-10 w-full shrink-0">
        <h1 class="text-brand-yellow text-3xl font-black tracking-wide">SGE</h1>
    </header>
    
    <!-- Main Content Area -->
    <div class="flex-1 flex p-6 gap-6 w-full max-w-[1400px] mx-auto h-[calc(100vh-60px)]">
        
        <!-- Sidebar -->
        <aside class="w-[80px] bg-brand-brown rounded-3xl p-4 flex flex-col gap-4 items-center h-full shadow-lg shrink-0">
            <!-- 1. Perfil/Editar -->
            <a href="{{ route('settings.profile') }}" class="w-12 h-12 bg-brand-light-brown/80 rounded-xl hover:bg-brand-light-brown transition-colors shadow-inner flex items-center justify-center group" title="Perfil">
                <svg class="w-6 h-6 text-brand-brown opacity-70 group-hover:opacity-100" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
            </a>
            <!-- 2. Lista de produtos -->
            <a href="#" class="w-12 h-12 bg-brand-light-brown/80 rounded-xl hover:bg-brand-light-brown transition-colors shadow-inner flex items-center justify-center group" title="Produtos">
                <svg class="w-6 h-6 text-brand-brown opacity-70 group-hover:opacity-100" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm0 2h10v7h-2l-1 2H8l-1-2H5V5z" clip-rule="evenodd"></path></svg>
            </a>
            <!-- 3. Histórico -->
            <a href="#" class="w-12 h-12 bg-brand-light-brown/80 rounded-xl hover:bg-brand-light-brown transition-colors shadow-inner flex items-center justify-center group" title="Histórico">
                <svg class="w-6 h-6 text-brand-brown opacity-70 group-hover:opacity-100" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path></svg>
            </a>
            <!-- 4. Funcionários -->
            <a href="{{ route('employees.create') }}" class="w-12 h-12 bg-brand-light-brown/80 rounded-xl hover:bg-brand-light-brown transition-colors shadow-inner flex items-center justify-center group" title="Funcionários">
                <svg class="w-6 h-6 text-brand-brown opacity-70 group-hover:opacity-100" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
            </a>
            <!-- 5. Suporte -->
            <a href="#" class="w-12 h-12 bg-brand-light-brown/80 rounded-xl hover:bg-brand-light-brown transition-colors shadow-inner flex items-center justify-center group" title="Suporte">
                <svg class="w-6 h-6 text-brand-brown opacity-70 group-hover:opacity-100" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
            </a>
        </aside>
        
        <!-- Main Dashboard Layout -->
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
    </div>
    
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.4);
        }
    </style>
</body>
</html>
