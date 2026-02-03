@if ($paginator->hasPages())
    <nav class="flex items-center gap-x-1" aria-label="Pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <button type="button" class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" disabled>
                <i data-lucide="chevron-left" class="w-3.5 h-3.5"></i>
                <span class="sr-only">Previous</span>
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" aria-label="Previous">
                <i data-lucide="chevron-left" class="w-3.5 h-3.5"></i>
                <span class="sr-only">Previous</span>
            </a>
        @endif

        <div class="flex items-center gap-x-1">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="min-h-[38px] min-w-[38px] flex justify-center items-center border border-transparent text-gray-500 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <button type="button" class="min-h-[38px] min-w-[38px] flex justify-center items-center border border-gray-200 text-gray-800 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none" aria-current="page">{{ $page }}</button>
                        @else
                            <a href="{{ $url }}" class="min-h-[38px] min-w-[38px] flex justify-center items-center border border-transparent text-gray-500 hover:text-indigo-600 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" aria-label="Next">
                <span class="sr-only">Next</span>
                <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
            </a>
        @else
            <button type="button" class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" disabled>
                <span class="sr-only">Next</span>
                <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
            </button>
        @endif
    </nav>
@endif
