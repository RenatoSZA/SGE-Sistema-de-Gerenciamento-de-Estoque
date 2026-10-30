@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Paginação de resultados" class="flex items-center justify-between gap-4 w-full text-xs font-bold text-white">
        <div class="hidden sm:block text-white/75">
            Mostrando <span class="text-brand-yellow">{{ $paginator->firstItem() }}</span> a <span class="text-brand-yellow">{{ $paginator->lastItem() }}</span> de <span class="text-brand-yellow">{{ $paginator->total() }}</span> registros
        </div>

        <div class="flex items-center gap-1 mx-auto sm:mx-0">
            {{-- Link Anterior --}}
            @if ($paginator->onFirstPage())
                <span aria-disabled="true" class="px-3 py-1.5 rounded-lg bg-white/5 text-white/30 cursor-not-allowed">&laquo; Anterior</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="px-3 py-1.5 rounded-lg bg-white/10 text-white hover:bg-brand-yellow hover:text-brand-brown transition-colors">&laquo; Anterior</a>
            @endif

            {{-- Números de Página --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span aria-disabled="true" class="px-2 py-1 text-white/50">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" class="px-3 py-1.5 rounded-lg bg-brand-yellow text-brand-brown font-black shadow-sm">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" aria-label="Ir para página {{ $page }}" class="px-3 py-1.5 rounded-lg bg-white/10 text-white hover:bg-brand-yellow hover:text-brand-brown transition-colors">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Próximo Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="px-3 py-1.5 rounded-lg bg-white/10 text-white hover:bg-brand-yellow hover:text-brand-brown transition-colors">Próxima &raquo;</a>
            @else
                <span aria-disabled="true" class="px-3 py-1.5 rounded-lg bg-white/5 text-white/30 cursor-not-allowed">Próxima &raquo;</span>
            @endif
        </div>
    </nav>
@endif
