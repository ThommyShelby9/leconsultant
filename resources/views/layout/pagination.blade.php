

@if ($paginator->hasPages())
<nav aria-label="Page navigation example">
    <ul class="flex list-style-none">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <!--li class="page-item disabled">
                <a rel="prev" aria-label="@lang('pagination.previous')"
                class="page-link  relative block py-1.5 px-3 rounded border-0 bg-transparent outline-none transition-all duration-300 rounded text-black hover:text-gray-800 focus:shadow-none"
                >Previous</a>
            </li-->
        @else
            <li class="page-item">
                <a rel="prev" aria-label="@lang('pagination.previous')"
                class="page-link  relative block py-1.5 px-3 rounded border-0 bg-transparent outline-none transition-all duration-300 rounded text-black hover:text-gray-800 focus:shadow-none"
                href="{{ $paginator->previousPageUrl() }}">Previous</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item">
                            <span
                            class="page-link relative block py-1.5 px-3 border-0  outline-none transition-all duration-300 rounded text-white bg-consultant-rouge focus:shadow-none"
                            >
                                {{ $page }}
                            </span>
                        </li>
                    @else
                        <li class="page-item">
                            <a
                            class="page-link relative block py-1.5 px-3 rounded border-0 bg-transparent outline-none transition-all duration-300 rounded text-black hover:text-white hover:bg-consultant-blue focus:shadow-none"
                            href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif

        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())

            <li class="page-item">
                <a rel="next" aria-label="@lang('pagination.next')"
                class="page-link relative block py-1.5 px-3 rounded border-0 bg-transparent outline-none transition-all duration-300 rounded text-black hover:text-white hover:bg-consultant-blue focus:shadow-none"
                href="{{ $paginator->nextPageUrl() }}">Suivant</a>
            </li>

        @else
            <!--li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span aria-hidden="true">&rsaquo;</span>
            </li-->
        @endif
    </ul>
</nav>
@endif
