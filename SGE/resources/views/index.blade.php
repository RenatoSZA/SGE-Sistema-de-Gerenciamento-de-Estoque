<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGE - Login</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-brand-yellow min-h-screen flex flex-col overflow-x-hidden antialiased">
    
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-2 focus:left-2 focus:z-50 focus:bg-brand-yellow focus:text-brand-brown focus:font-black focus:px-4 focus:py-2 focus:rounded-lg focus:shadow-lg focus:outline-none focus:ring-2 focus:ring-brand-brown">
        Pular para o formulário de login
    </a>

    <header class="bg-brand-brown h-[70px] flex justify-center items-center shadow-md relative z-10 w-full">
        <h1 class="text-brand-yellow text-3xl font-black tracking-wide">SGE</h1>
    </header>
    
    <main id="main-content" tabindex="-1" class="flex-1 flex justify-center items-center p-8 focus:outline-none">
        
        <div class="bg-brand-brown w-full max-w-[500px] rounded-[20px] relative px-10 pb-10 pt-[70px] shadow-2xl motion-safe:animate-[fadeUp_0.8s_ease-out_forwards]">
            
            <h2 class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 text-[80px] font-black tracking-[2px] uppercase bg-gradient-to-b from-brand-brown from-50% to-brand-yellow to-50% bg-clip-text text-transparent pointer-events-none select-none leading-none whitespace-nowrap">
                LOGIN
            </h2>
            
            <div class="flex flex-col items-center">
                <h3 class="text-white text-xl font-bold mb-10">Bem vindo!</h3>
                
                <form method="POST" action="{{ route('site.login') }}" class="w-full max-w-[320px] flex flex-col gap-4" novalidate>
                    @csrf
                    
                    <div class="flex flex-col w-full">
                        <x-input 
                            id="matricula"
                            name="matricula" 
                            label="Matrícula (Ex: F20260001)"
                            placeholder="Matrícula" 
                            value="{{ old('matricula') }}" 
                            required
                            autocomplete="username"
                            aria-invalid="{{ $errors->has('matricula') ? 'true' : 'false' }}"
                            aria-describedby="{{ $errors->has('matricula') ? 'matricula-error' : 'matricula-hint' }}"
                        />
                        <span id="matricula-hint" class="sr-only">Formato esperado: letra F, G ou A seguida de 8 números (ex: F20260001).</span>
                        @error('matricula')
                            <span id="matricula-error" role="alert" class="text-red-300 text-xs font-bold mt-1 pl-2">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="flex flex-col w-full">
                        <x-input 
                            id="password"
                            type="password" 
                            name="password" 
                            label="Senha"
                            placeholder="Senha" 
                            icon="eye" 
                            required
                            autocomplete="current-password"
                            aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                            aria-describedby="{{ $errors->has('password') ? 'password-error' : '' }}"
                        />
                        @error('password')
                            <span id="password-error" role="alert" class="text-red-300 text-xs font-bold mt-1 pl-2">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="mt-2 w-full flex flex-col gap-3 items-center">
                        <x-button type="submit" variant="primary" size="md" class="w-full">
                            Login
                        </x-button>
                    </div>

                </form>
                
                <div class="mt-8 text-center flex flex-col gap-1">
                    <p class="text-white text-xs font-bold">Esqueceu sua senha ou é seu primeiro login?</p>
                    <a href="{{ route('password.request') }}" class="text-brand-yellow text-xs font-bold no-underline hover:underline hover:brightness-110 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow rounded px-1 transition-all">
                        Clique aqui para recuperar o acesso.
                    </a>
                </div>
            </div>
            
        </div>
        
    </main>
</body>
</html>
