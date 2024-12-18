@if ($paginator->hasPages())
    <div class="pagination-info">
        Menampilkan {{ $paginator->firstItem() }} sampai {{ $paginator->lastItem() }} dari {{ $paginator->total() }}
        hasil
    </div>
    // ... kode pagination lainnya ...
@endif
