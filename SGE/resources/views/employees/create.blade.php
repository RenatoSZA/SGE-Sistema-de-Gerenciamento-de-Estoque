<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGE Cadastro de Funcionário</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-brand-yellow min-h-screen flex flex-col overflow-x-hidden antialiased">
    
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-2 focus:left-2 focus:z-50 focus:bg-brand-yellow focus:text-brand-brown focus:font-black focus:px-4 focus:py-2 focus:rounded-lg focus:shadow-lg focus:outline-none focus:ring-2 focus:ring-brand-brown">
        Pular para o formulário de cadastro
    </a>

    <header class="bg-brand-brown h-[70px] flex justify-center items-center shadow-md relative z-10 w-full">
        <h1 class="text-brand-yellow text-3xl font-black tracking-wide">
            <a href="{{ route('dashboard') }}" aria-label="SGE - Ir para o Dashboard" class="focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow rounded px-2">SGE</a>
        </h1>
    </header>
    
    <main id="main-content" tabindex="-1" class="flex-1 flex justify-center items-center p-8 focus:outline-none">
        <div class="relative w-full max-w-[900px] mt-10">
            <!-- Header title matching the image -->
            <h2 class="absolute -top-10 left-1/2 -translate-x-1/2 text-[40px] md:text-[60px] font-black tracking-wider uppercase text-brand-yellow whitespace-nowrap z-20" style="-webkit-text-stroke: 8px #4B3631; paint-order: stroke fill;">
                CADASTRO DE FUNCIONÁRIO
            </h2>
            
            <form method="POST" action="{{ route('employees.store') }}" class="bg-brand-brown w-full rounded-[30px] pt-20 pb-12 px-10 shadow-2xl relative" novalidate>
                @csrf
                
                @if(session('success'))
                    <div role="status" aria-live="polite" class="mb-6 p-4 bg-green-500/20 border border-green-400 rounded-xl text-green-300 font-bold text-center">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="flex flex-col md:flex-row gap-10">
                    
                    <!-- Left Column -->
                    <div class="flex-1 bg-brand-light-brown/60 rounded-[20px] p-8 flex flex-col justify-between">
                        <div>
                            <h3 class="text-white text-xl font-bold mb-8 text-center uppercase tracking-wide">Informações do Funcionário</h3>
                            
                            <div class="flex flex-col gap-6">
                                <div class="flex flex-col">
                                    <x-input 
                                        id="nome" 
                                        name="nome" 
                                        label="Nome Completo" 
                                        placeholder="Nome" 
                                        value="{{ old('nome') }}" 
                                        required
                                        autocomplete="name"
                                        aria-invalid="{{ $errors->has('nome') ? 'true' : 'false' }}"
                                        aria-describedby="{{ $errors->has('nome') ? 'nome-error' : '' }}"
                                    />
                                    @error('nome')
                                        <span id="nome-error" role="alert" class="text-red-300 text-xs font-bold mt-1 pl-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="flex flex-col">
                                    <x-input 
                                        id="email" 
                                        type="email" 
                                        name="email" 
                                        label="E-mail Profissional" 
                                        placeholder="Email" 
                                        value="{{ old('email') }}" 
                                        required
                                        autocomplete="email"
                                        aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                                        aria-describedby="{{ $errors->has('email') ? 'email-error' : '' }}"
                                    />
                                    @error('email')
                                        <span id="email-error" role="alert" class="text-red-300 text-xs font-bold mt-1 pl-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="flex flex-col">
                                    <x-input 
                                        id="cpf" 
                                        name="cpf" 
                                        label="CPF (somente números ou formato 000.000.000-00)" 
                                        placeholder="CPF" 
                                        value="{{ old('cpf') }}" 
                                        required
                                        aria-invalid="{{ $errors->has('cpf') ? 'true' : 'false' }}"
                                        aria-describedby="{{ $errors->has('cpf') ? 'cpf-error' : '' }}"
                                    />
                                    @error('cpf')
                                        <span id="cpf-error" role="alert" class="text-red-300 text-xs font-bold mt-1 pl-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-12 flex justify-start">
                            <button type="reset" class="bg-brand-yellow hover:brightness-110 focus:outline-none focus-visible:ring-4 focus-visible:ring-white text-brand-brown font-black px-8 py-3 rounded-xl uppercase tracking-widest transition-all shadow-md">
                                Restaurar
                            </button>
                        </div>
                    </div>
                    
                    <!-- Right Column -->
                    <div class="flex-1 flex flex-col justify-between">
                        <div class="bg-brand-light-brown/60 rounded-[20px] p-8">
                            <h3 class="text-white text-xl font-bold mb-8 text-center uppercase tracking-wide">Função</h3>
                            
                            <div class="flex flex-col gap-6">
                                <div class="flex flex-col relative group">
                                    <label for="nivel_acesso" class="sr-only">Cargo / Nível de Acesso</label>
                                    <select id="nivel_acesso" name="nivel_acesso" required aria-invalid="{{ $errors->has('nivel_acesso') ? 'true' : 'false' }}" aria-describedby="{{ $errors->has('nivel_acesso') ? 'nivel-acesso-error' : '' }}" class="w-full px-4 py-3 rounded-lg bg-white border-2 border-transparent text-brand-brown font-bold focus:outline-none focus:border-brand-yellow focus:ring-4 focus:ring-brand-yellow/40 appearance-none transition-all shadow-sm cursor-pointer">
                                        <option value="" disabled {{ old('nivel_acesso') ? '' : 'selected' }} class="text-brand-brown/80">Cargo</option>
                                        <option value="Funcionario" {{ old('nivel_acesso') == 'Funcionario' ? 'selected' : '' }}>Funcionário</option>
                                        <option value="Gerente" {{ old('nivel_acesso') == 'Gerente' ? 'selected' : '' }}>Gerente</option>
                                        @if(auth()->user() && auth()->user()->nivel_acesso === 'Admin')
                                            <option value="Admin" {{ old('nivel_acesso') == 'Admin' ? 'selected' : '' }}>Administrador</option>
                                        @endif
                                    </select>
                                    <div aria-hidden="true" class="absolute right-4 top-1/2 -translate-y-1/2 text-brand-brown pointer-events-none">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                    @error('nivel_acesso')
                                        <span id="nivel-acesso-error" role="alert" class="text-red-300 text-xs font-bold mt-1 pl-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="flex flex-col">
                                    <x-input 
                                        id="departamento" 
                                        name="departamento" 
                                        label="Setor / Departamento" 
                                        placeholder="Setor" 
                                        value="{{ old('departamento') }}" 
                                        required
                                        aria-invalid="{{ $errors->has('departamento') ? 'true' : 'false' }}"
                                        aria-describedby="{{ $errors->has('departamento') ? 'departamento-error' : '' }}"
                                    />
                                    @error('departamento')
                                        <span id="departamento-error" role="alert" class="text-red-300 text-xs font-bold mt-1 pl-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-12 flex justify-end">
                            <button type="submit" class="bg-brand-yellow hover:brightness-110 focus:outline-none focus-visible:ring-4 focus-visible:ring-white text-brand-brown font-black px-12 py-4 rounded-xl uppercase tracking-widest text-lg transition-all shadow-md">
                                Registrar
                            </button>
                        </div>
                    </div>
                    
                </div>
            </form>
        </div>
    </main>
</body>
</html>
