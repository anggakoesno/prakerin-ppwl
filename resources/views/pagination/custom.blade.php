@if ($paginator->hasPages())
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem; font-size: 0.85rem; color: #555;">
        <div>
            Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }} data
        </div>
        <div style="display: flex; gap: 0.25rem; align-items: center;">
            @if ($paginator->onFirstPage())
                <span style="padding: 0.3rem 0.6rem; color: #bbb; border: 1px solid #e3e3e0; border-radius: 4px;">&laquo;</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" style="padding: 0.3rem 0.6rem; color: #444; border: 1px solid #e3e3e0; border-radius: 4px; text-decoration: none;">&laquo;</a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span style="padding: 0.3rem 0.4rem; color: #999;">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span style="padding: 0.3rem 0.6rem; background: #1b1b18; color: #fff; border-radius: 4px;">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" style="padding: 0.3rem 0.6rem; color: #444; border: 1px solid #e3e3e0; border-radius: 4px; text-decoration: none;">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" style="padding: 0.3rem 0.6rem; color: #444; border: 1px solid #e3e3e0; border-radius: 4px; text-decoration: none;">&raquo;</a>
            @else
                <span style="padding: 0.3rem 0.6rem; color: #bbb; border: 1px solid #e3e3e0; border-radius: 4px;">&raquo;</span>
            @endif
        </div>
    </div>
@endif
