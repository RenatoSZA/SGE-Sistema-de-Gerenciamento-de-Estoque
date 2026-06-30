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

<section class="flex-1 bg-brand-brown rounded-3xl p-6 shadow-xl flex flex-col overflow-y-auto custom-scrollbar h-full relative">
    
    <div class="mb-6 border-b border-white/10 pb-4">
        <h2 class="text-white text-xl md:text-2xl font-black tracking-wide uppercase">
            {{ __('ATUALIZAR SENHA') }}
        </h2>
        <p class="text-white/60 text-sm font-medium mt-1">Garanta que sua conta esteja usando uma senha longa e segura.</p>
    </div>

    <form wire:submit="updatePassword" class="flex flex-col gap-5 flex-1 max-w-3xl">
        
        <div>
            <label class="block text-white/70 text-xs font-bold mb-1 uppercase tracking-wider">{{ __('Senha Atual') }}</label>
            <input wire:model="current_password" type="password" required autocomplete="current-password" class="w-full bg-white/5 border border-white/10 focus:border-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium">
            @error('current_password') <span class="text-red-400 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-white/70 text-xs font-bold mb-1 uppercase tracking-wider">{{ __('Nova Senha') }}</label>
            <input wire:model="password" type="password" required autocomplete="new-password" class="w-full bg-white/5 border border-white/10 focus:border-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium">
            @error('password') <span class="text-red-400 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-white/70 text-xs font-bold mb-1 uppercase tracking-wider">{{ __('Confirmar Nova Senha') }}</label>
            <input wire:model="password_confirmation" type="password" required autocomplete="new-password" class="w-full bg-white/5 border border-white/10 focus:border-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium">
            @error('password_confirmation') <span class="text-red-400 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center gap-4 mt-4 pt-4 border-t border-white/10">
            <button type="submit" class="px-8 py-2 rounded-full font-bold bg-brand-yellow text-brand-brown hover:bg-white shadow-md transition-colors">
                {{ __('Salvar Nova Senha') }}
            </button>

            <x-action-message class="me-3 text-green-400 font-bold text-sm" on="password-updated">
                {{ __('Senha atualizada com sucesso.') }}
            </x-action-message>
        </div>
    </form>

</section>
