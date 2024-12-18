@if ($paginator->hasPages())
    <div class="pagination">
        {{-- Informasi hasil --}}
        <div class="pagination-info">
            Menampilkan {{ $paginator->firstItem() }} sampai {{ $paginator->lastItem() }}
            dari {{ $paginator->total() }} hasil
        </div>

        {{-- Tombol navigasi --}}
        <div class="pagination-links">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="disabled">&laquo; Sebelumnya</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}">&laquo; Sebelumnya</a>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}">Selanjutnya &raquo;</a>
            @else
                <span class="disabled">Selanjutnya &raquo;</span>
            @endif
        </div>
    </div>
@endif
