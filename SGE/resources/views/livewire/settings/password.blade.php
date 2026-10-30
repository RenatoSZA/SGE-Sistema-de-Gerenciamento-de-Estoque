<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.sge')] class extends Component {
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section aria-labelledby="heading-atualizar-senha" class="flex-1 bg-brand-brown rounded-3xl p-6 shadow-xl flex flex-col overflow-y-auto custom-scrollbar h-full relative">
    
    <!-- Sub-navegação Perfil / Senha -->
    <div class="flex gap-2 mb-6 border-b border-white/10 pb-4">
        <a href="{{ route('settings.profile') }}" class="px-5 py-2 rounded-xl font-bold text-sm transition-colors {{ request()->routeIs('settings.profile') ? 'bg-brand-yellow text-brand-brown shadow-sm' : 'bg-white/10 text-white hover:bg-white/20' }}">
            Meu Perfil
        </a>
        <a href="{{ route('settings.password') }}" class="px-5 py-2 rounded-xl font-bold text-sm transition-colors {{ request()->routeIs('settings.password') ? 'bg-brand-yellow text-brand-brown shadow-sm' : 'bg-white/10 text-white hover:bg-white/20' }}">
            Alterar Senha
        </a>
    </div>

    <div class="mb-6">
        <h2 id="heading-atualizar-senha" class="text-white text-xl md:text-2xl font-black tracking-wide uppercase">
            {{ __('SEGURANÇA DA CONTA') }}
        </h2>
        <p class="text-white/80 text-sm font-medium mt-1">Garanta que sua conta esteja usando uma senha longa e segura.</p>
    </div>

    <form wire:submit="updatePassword" class="flex flex-col gap-5 flex-1 max-w-3xl">
        
        <div>
            <label for="current_password" class="block text-white/80 text-xs font-bold mb-1 uppercase tracking-wider">{{ __('Senha Atual') }}</label>
            <input id="current_password" wire:model="current_password" type="password" required autocomplete="current-password" aria-invalid="{{ $errors->has('current_password') ? 'true' : 'false' }}" aria-describedby="{{ $errors->has('current_password') ? 'current-password-error' : '' }}" class="w-full bg-white/5 border border-white/20 focus:border-brand-yellow focus:ring-2 focus:ring-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium">
            @error('current_password') <span id="current-password-error" role="alert" class="text-red-300 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="new_password" class="block text-white/80 text-xs font-bold mb-1 uppercase tracking-wider">{{ __('Nova Senha') }}</label>
            <input id="new_password" wire:model="password" type="password" required autocomplete="new-password" aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}" aria-describedby="{{ $errors->has('password') ? 'new-password-error' : '' }}" class="w-full bg-white/5 border border-white/20 focus:border-brand-yellow focus:ring-2 focus:ring-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium">
            @error('password') <span id="new-password-error" role="alert" class="text-red-300 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-white/80 text-xs font-bold mb-1 uppercase tracking-wider">{{ __('Confirmar Nova Senha') }}</label>
            <input id="password_confirmation" wire:model="password_confirmation" type="password" required autocomplete="new-password" aria-invalid="{{ $errors->has('password_confirmation') ? 'true' : 'false' }}" aria-describedby="{{ $errors->has('password_confirmation') ? 'password-confirmation-error' : '' }}" class="w-full bg-white/5 border border-white/20 focus:border-brand-yellow focus:ring-2 focus:ring-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium">
            @error('password_confirmation') <span id="password-confirmation-error" role="alert" class="text-red-300 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center gap-4 mt-4 pt-4 border-t border-white/10">
            <button type="submit" class="px-8 py-2 rounded-full font-bold bg-brand-yellow text-brand-brown hover:bg-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white shadow-md transition-colors">
                {{ __('Salvar Nova Senha') }}
            </button>

            <x-action-message class="me-3 text-green-300 font-bold text-sm" on="password-updated">
                {{ __('Senha atualizada com sucesso.') }}
            </x-action-message>
        </div>
    </form>

</section>
