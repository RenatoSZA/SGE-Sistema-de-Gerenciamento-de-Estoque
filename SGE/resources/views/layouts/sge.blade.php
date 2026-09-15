<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGE - @yield('title', 'Dashboard')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-brand-yellow min-h-screen flex flex-col overflow-x-hidden antialiased">
    
    <!-- Header -->
    <header class="bg-brand-brown h-[60px] flex justify-center items-center shadow-md relative z-10 w-full shrink-0">
        <h1 class="text-brand-yellow text-3xl font-black tracking-wide">
            <a href="{{ route('dashboard') }}">SGE</a>
        </h1>
    </header>
    
    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col md:flex-row p-4 md:p-6 gap-4 md:gap-6 w-full max-w-[1400px] mx-auto h-[calc(100vh-60px)]">
        
        <!-- Sidebar -->
        <aside class="w-full md:w-[80px] h-auto md:h-full overflow-x-auto md:overflow-visible bg-brand-brown rounded-3xl p-3 md:p-4 flex flex-row md:flex-col gap-2 md:gap-4 justify-between md:justify-start items-center shadow-lg shrink-0 z-20 custom-scrollbar">
            <!-- 1. Perfil/Editar -->
            <a href="{{ route('settings.profile') }}" class="w-12 h-12 rounded-xl transition-colors shadow-inner flex items-center justify-center group {{ request()->routeIs('settings.*') ? 'bg-brand-yellow text-brand-brown' : 'bg-brand-light-brown/80 hover:bg-brand-light-brown text-brand-brown opacity-70 group-hover:opacity-100' }}" title="Perfil">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
            </a>
            <!-- 2. Lista de produtos -->
            <a href="{{ route('products.index') }}" class="w-12 h-12 rounded-xl transition-colors shadow-inner flex items-center justify-center group {{ request()->routeIs('products.*') ? 'bg-brand-yellow text-brand-brown' : 'bg-brand-light-brown/80 hover:bg-brand-light-brown text-brand-brown opacity-70 group-hover:opacity-100' }}" title="Produtos">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm0 2h10v7h-2l-1 2H8l-1-2H5V5z" clip-rule="evenodd"></path></svg>
            </a>
            <!-- 3. Histórico -->
            <a href="{{ route('stock.history') }}" class="w-12 h-12 rounded-xl transition-colors shadow-inner flex items-center justify-center group {{ request()->routeIs('stock.history') ? 'bg-brand-yellow text-brand-brown' : 'bg-brand-light-brown/80 hover:bg-brand-light-brown text-brand-brown opacity-70 group-hover:opacity-100' }}" title="Histórico">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path></svg>
            </a>
            <!-- 4. Funcionários -->
            <a href="{{ route('employees.index') }}" class="w-12 h-12 rounded-xl transition-colors shadow-inner flex items-center justify-center group {{ request()->routeIs('employees.*') ? 'bg-brand-yellow text-brand-brown' : 'bg-brand-light-brown/80 hover:bg-brand-light-brown text-brand-brown opacity-70 group-hover:opacity-100' }}" title="Funcionários">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
            </a>
            <!-- 5. Suporte -->
            <a href="{{ route('support.index') }}" class="w-12 h-12 rounded-xl transition-colors shadow-inner flex items-center justify-center group {{ request()->routeIs('support.*') ? 'bg-brand-yellow text-brand-brown' : 'bg-brand-light-brown/80 hover:bg-brand-light-brown text-brand-brown opacity-70 group-hover:opacity-100' }}" title="Suporte">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
            </a>
        </aside>
        
        <!-- Main Area (Dynamic) -->
        @yield('content')
        {{ $slot ?? '' }}
        
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
    
    <!-- Global Toast Notification System -->
    <div x-data="{ toasts: [] }" 
         @toast.window="toasts.push($event.detail); setTimeout(() => { toasts.shift() }, 4000)"
         class="fixed bottom-6 right-6 z-50 flex flex-col gap-3 pointer-events-none">
        <template x-for="(toast, index) in toasts" :key="index">
            <div x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-x-8"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform translate-x-0"
                 x-transition:leave-end="opacity-0 transform translate-x-8"
                 class="px-5 py-3 rounded-xl font-bold text-sm shadow-2xl flex items-center gap-2 pointer-events-auto max-w-sm border border-black/10"
                 :class="toast.type === 'success' ? 'bg-green-400 text-green-900' : (toast.type === 'error' ? 'bg-red-400 text-red-900' : 'bg-brand-yellow text-brand-brown')">
                <span x-text="toast.message"></span>
            </div>
        </template>
    </div>

    <!-- Catch Laravel Session Flashes -->
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                setTimeout(() => window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'success', message: '{{ session("success") }}' } })), 100);
            });
        </script>
    @endif
    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                setTimeout(() => window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', message: '{{ session("error") }}' } })), 100);
            });
        </script>
    @endif

</body>
</html>
