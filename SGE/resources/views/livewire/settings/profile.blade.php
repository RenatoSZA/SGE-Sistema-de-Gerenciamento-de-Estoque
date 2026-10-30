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

<section aria-labelledby="heading-meu-perfil" class="flex-1 bg-brand-brown rounded-3xl p-6 shadow-xl flex flex-col overflow-y-auto custom-scrollbar h-full relative">
    
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
        <h2 id="heading-meu-perfil" class="text-white text-xl md:text-2xl font-black tracking-wide uppercase">
            {{ __('DADOS DA CONTA') }}
        </h2>
        <p class="text-white/80 text-sm font-medium mt-1">Atualize seu nome e endereço de e-mail corporativo.</p>
    </div>

    <form wire:submit="updateProfileInformation" class="flex flex-col gap-5 flex-1 max-w-3xl">
        
        <div>
            <label for="profile-name" class="block text-white/80 text-xs font-bold mb-1 uppercase tracking-wider">{{ __('Nome Completo') }}</label>
            <input id="profile-name" wire:model="name" type="text" required autofocus autocomplete="name" aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}" aria-describedby="{{ $errors->has('name') ? 'profile-name-error' : '' }}" class="w-full bg-white/5 border border-white/20 focus:border-brand-yellow focus:ring-2 focus:ring-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium">
            @error('name') <span id="profile-name-error" role="alert" class="text-red-300 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="profile-email" class="block text-white/80 text-xs font-bold mb-1 uppercase tracking-wider">{{ __('E-mail') }}</label>
            <input id="profile-email" wire:model="email" type="email" required autocomplete="email" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" aria-describedby="{{ $errors->has('email') ? 'profile-email-error' : '' }}" class="w-full bg-white/5 border border-white/20 focus:border-brand-yellow focus:ring-2 focus:ring-brand-yellow text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium">
            @error('email') <span id="profile-email-error" role="alert" class="text-red-300 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div role="status" class="bg-brand-yellow/10 border border-brand-yellow/30 p-3 rounded-lg mt-3">
                    <p class="text-sm text-white/90">
                        {{ __('Seu endereço de e-mail não está verificado.') }}
                        <button type="button" wire:click.prevent="resendVerificationNotification" class="font-bold text-brand-yellow hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-yellow rounded px-1 ml-1">
                            {{ __('Clique aqui para reenviar o e-mail de verificação.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p role="status" aria-live="polite" class="mt-2 text-sm font-bold text-green-300">
                            {{ __('Um novo link de verificação foi enviado para seu e-mail.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 mt-4 pt-4 border-t border-white/10">
            <button type="submit" class="px-8 py-2 rounded-full font-bold bg-brand-yellow text-brand-brown hover:bg-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white shadow-md transition-colors">
                {{ __('Salvar Alterações') }}
            </button>

            <x-action-message class="me-3 text-green-300 font-bold text-sm" on="profile-updated">
                {{ __('Salvo com sucesso.') }}
            </x-action-message>
        </div>
    </form>

</section>
