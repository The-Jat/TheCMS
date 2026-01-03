@if ($paginator->hasPages())
    <nav class="pagination-bx clearfix text-center">
        <div class="pagination">
            <ul class="pagination">

                @if ($paginator->onFirstPage())
                @else
                    <li>
                        <a class="prev page-numbers" href="{{ $paginator->previousPageUrl() }}">
                            <i class="ti-arrow-left"></i>
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li><span class="page-numbers">{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li><span aria-current="page" class="page-numbers current">{{ $page }}</span></li>
                            @else
                                <li>
                                    <a class="page-numbers" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li>
                        <a class="next page-numbers" href="{{ $paginator->nextPageUrl() }}">
                            <i class="ti-arrow-right"></i>
                        </a>
                    </li>
                @else
                @endif

                
            </ul>
        </div>
    </nav>
@endif