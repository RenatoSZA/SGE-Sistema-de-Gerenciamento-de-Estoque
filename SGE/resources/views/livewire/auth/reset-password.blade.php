<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('components.layouts.guest')] class extends Component {
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status != Password::PasswordReset) {
            $this->addError('email', __($status));

            return;
        }

        Session::flash('status', __($status));

        $this->redirectRoute('login', navigate: true);
    }
}; ?>

<div class="font-sans bg-brand-yellow min-h-screen flex items-center justify-center antialiased p-6 relative overflow-hidden fixed inset-0">
    <!-- Elemento decorativo de fundo -->
    <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] bg-brand-brown/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-[20%] -right-[10%] w-[60%] h-[60%] bg-brand-brown/10 rounded-full blur-3xl pointer-events-none"></div>

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
                    <svg class="w-8 h-8 text-brand-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h2 class="text-white text-2xl font-black tracking-wide">NOVA SENHA</h2>
                <p class="text-white/60 text-sm mt-2 font-medium">Digite sua nova senha abaixo para recuperar o acesso.</p>
            </div>

            <x-auth-session-status class="mb-4 text-center text-green-400 font-bold" :status="session('status')" />

            <form wire:submit="resetPassword" class="flex flex-col gap-5">
                
                <div>
                    <label class="block text-white/70 text-xs font-bold mb-2 uppercase tracking-wider">Email</label>
                    <div class="relative">
                        <input wire:model="email" type="email" placeholder="seu@email.com.br" required readonly class="w-full bg-white/5 border border-white/10 text-white/70 rounded-xl px-4 py-3 outline-none transition-all font-medium cursor-not-allowed">
                    </div>
                    @error('email') <span class="text-red-400 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-white/70 text-xs font-bold mb-2 uppercase tracking-wider">Nova Senha</label>
                    <div class="relative">
                        <input wire:model="password" type="password" placeholder="Sua nova senha" required class="w-full bg-white/5 border border-white/10 focus:border-brand-yellow focus:bg-white/10 text-white rounded-xl px-4 py-3 pl-11 outline-none transition-all font-medium">
                        <svg class="w-5 h-5 text-white/40 absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    @error('password') <span class="text-red-400 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-white/70 text-xs font-bold mb-2 uppercase tracking-wider">Confirmar Nova Senha</label>
                    <div class="relative">
                        <input wire:model="password_confirmation" type="password" placeholder="Repita a nova senha" required class="w-full bg-white/5 border border-white/10 focus:border-brand-yellow focus:bg-white/10 text-white rounded-xl px-4 py-3 pl-11 outline-none transition-all font-medium">
                        <svg class="w-5 h-5 text-white/40 absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    @error('password_confirmation') <span class="text-red-400 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="w-full bg-brand-yellow text-brand-brown font-black tracking-wide uppercase py-3.5 rounded-xl hover:bg-white hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                        Confirmar e Acessar
                    </button>
                </div>
            </form>

        </div>
        
    </div>
</div>
