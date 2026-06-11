<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGE Login</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-brand-yellow min-h-screen flex flex-col overflow-x-hidden antialiased">
    
    <header class="bg-brand-brown h-[70px] flex justify-center items-center shadow-md relative z-10 w-full">
        <h1 class="text-brand-yellow text-3xl font-black tracking-wide">SGE</h1>
    </header>
    
    <main class="flex-1 flex justify-center items-center p-8">
        
        <div class="bg-brand-brown w-full max-w-[500px] rounded-[20px] relative px-10 pb-10 pt-[70px] shadow-2xl animate-[fadeUp_0.8s_ease-out_forwards]">
            
            <h2 class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 text-[80px] font-black tracking-[2px] uppercase bg-gradient-to-b from-brand-brown from-50% to-brand-yellow to-50% bg-clip-text text-transparent pointer-events-none select-none leading-none whitespace-nowrap">
                LOGIN
            </h2>
            
            <div class="flex flex-col items-center">
                <h3 class="text-white text-xl font-bold mb-10">Bem vindo!</h3>
                
                <form method="POST" action="{{ route('site.login') }}" class="w-full max-w-[320px] flex flex-col gap-4">
                    @csrf
                    
                    <div class="flex flex-col w-full">
                        <x-input name="matricula" placeholder="Matrícula" value="{{ old('matricula') }}" />
                        @error('matricula')
                            <span class="text-red-400 text-xs font-bold mt-1 pl-2">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <x-input type="password" name="password" placeholder="Senha" icon="eye" />
                    
                    <div class="mt-2 w-full flex flex-col gap-3 items-center">
                        <x-button type="submit" variant="primary" size="md" class="w-full">
                            Login
                        </x-button>
                    </div>

                </form>
                
                <div class="mt-8 text-center flex flex-col gap-1">
                    <p class="text-white text-[10px] font-bold">Esqueceu sua senha ou é seu primeiro login?</p>
                    <a href="#" class="text-brand-yellow text-[10px] font-bold no-underline hover:underline hover:brightness-110 transition-all">Clique aqui.</a>
                </div>
            </div>
            
        </div>
        
    </main>
</body>
</html>
