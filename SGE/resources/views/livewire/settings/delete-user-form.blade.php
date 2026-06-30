<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="flex flex-col gap-5 max-w-3xl">
    <div class="mb-2">
        <h3 class="text-red-500 text-lg font-black tracking-wide uppercase">{{ __('Excluir Conta') }}</h3>
        <p class="text-white/60 text-sm font-medium mt-1">{{ __('Excluir permanentemente sua conta e todos os dados vinculados a ela.') }}</p>
    </div>

    <div x-data="{ confirmingUserDeletion: false }">
        <button type="button" x-on:click="confirmingUserDeletion = true" class="px-6 py-2 rounded-full font-bold bg-red-500/20 text-red-400 hover:bg-red-500 hover:text-white border border-red-500/30 transition-colors">
            {{ __('Excluir Conta') }}
        </button>

        <!-- Modal -->
        <div x-show="confirmingUserDeletion" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                
                <!-- Background overlay -->
                <div x-show="confirmingUserDeletion" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/70 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                
                <!-- Modal panel -->
                <div x-show="confirmingUserDeletion" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" @click.away="confirmingUserDeletion = false" class="inline-block align-bottom bg-brand-brown rounded-3xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-red-500/30 p-6">
                    
                    <form wire:submit="deleteUser" class="flex flex-col gap-4">
                        <div>
                            <h3 class="text-white text-xl font-black tracking-wide" id="modal-title">{{ __('Tem certeza que deseja excluir sua conta?') }}</h3>
                            <p class="text-white/60 text-sm mt-2">
                                {{ __('Uma vez excluída, todos os seus dados serão apagados permanentemente. Por favor, digite sua senha para confirmar.') }}
                            </p>
                        </div>

                        <div class="mt-2">
                            <label class="block text-white/70 text-xs font-bold mb-1 uppercase tracking-wider">{{ __('Senha') }}</label>
                            <input wire:model="password" type="password" required placeholder="Digite sua senha" class="w-full bg-white/5 border border-white/10 focus:border-red-500 text-white rounded-lg px-4 py-3 outline-none transition-colors font-medium">
                            @error('password') <span class="text-red-400 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end gap-3 mt-4 pt-4 border-t border-white/10">
                            <button type="button" x-on:click="confirmingUserDeletion = false" class="px-6 py-2 rounded-full font-bold text-white hover:bg-white/10 border border-transparent transition-colors">
                                {{ __('Cancelar') }}
                            </button>
                            <button type="submit" class="px-8 py-2 rounded-full font-bold bg-red-500 text-white hover:bg-red-600 shadow-md transition-colors">
                                {{ __('Sim, Excluir Conta') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
