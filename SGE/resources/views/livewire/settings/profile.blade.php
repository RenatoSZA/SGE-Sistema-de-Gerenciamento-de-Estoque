<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.sge')] class extends Component {
    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id)
            ],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section class="flex-1 bg-brand-brown rounded-3xl p-6 shadow-xl flex flex-col overflow-y-auto custom-scrollbar h-full relative">
    
    <div class="mb-6 border-b border-white/10 pb-4">
        <h2 class="text-white text-xl md:text-2xl font-black tracking-wide uppercase">
            {{ __('MEU PERFIL') }}
        </h2>
        <p class="text-white/60 text-sm font-medium mt-1">Atualize seu nome e endereço de e-mail.</p>
    </div>

    <form wire:submit="updateProfileInformation" class="flex flex-col gap-5 flex-1 max-w-3xl">
        
        <div>
            <label class="block text-white/70 text-xs font-bold mb-1 uppercase tracking-wider">{{ __('Nome Completo') }}</label>
            <input wire:model="name" type="text" required autofocus autocomplete="name" class="w-full bg-white/5 border border-white/10 focus:border-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium">
            @error('name') <span class="text-red-400 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-white/70 text-xs font-bold mb-1 uppercase tracking-wider">{{ __('E-mail') }}</label>
            <input wire:model="email" type="email" required autocomplete="email" class="w-full bg-white/5 border border-white/10 focus:border-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium">
            @error('email') <span class="text-red-400 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div class="bg-brand-yellow/10 border border-brand-yellow/30 p-3 rounded-lg mt-3">
                    <p class="text-sm text-white/80">
                        {{ __('Seu endereço de e-mail não está verificado.') }}
                        <button wire:click.prevent="resendVerificationNotification" class="font-bold text-brand-yellow hover:underline ml-1">
                            {{ __('Clique aqui para reenviar o e-mail de verificação.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-bold text-green-400">
                            {{ __('Um novo link de verificação foi enviado para seu e-mail.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 mt-4 pt-4 border-t border-white/10">
            <button type="submit" class="px-8 py-2 rounded-full font-bold bg-brand-yellow text-brand-brown hover:bg-white shadow-md transition-colors">
                {{ __('Salvar Alterações') }}
            </button>

            <x-action-message class="me-3 text-green-400 font-bold text-sm" on="profile-updated">
                {{ __('Salvo com sucesso.') }}
            </x-action-message>
        </div>
    </form>

    <div class="mt-12 pt-8 border-t border-white/10">
        <livewire:settings.delete-user-form />
    </div>

</section>
