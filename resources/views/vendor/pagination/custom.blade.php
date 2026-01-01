@if ($paginator->hasPages())
<div class="d-flex justify-content-between align-items-center mt-3 custom-pagination-controls w-100 px-3">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
    <button class="btn btn-sm btn-outline-secondary rounded-pill px-3" disabled>
        <span class="material-symbols-outlined fs-6 align-middle">chevron_left</span> Prev
    </button>
    @else
    <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
        <span class="material-symbols-outlined fs-6 align-middle">chevron_left</span> Prev
    </a>
    @endif

    {{-- Page Indicator --}}
    <span class="small text-muted fw-medium">Page {{ $paginator->currentPage() }}</span>

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
        Next <span class="material-symbols-outlined fs-6 align-middle">chevron_right</span>
    </a>
    @else
    <button class="btn btn-sm btn-outline-secondary rounded-pill px-3" disabled>
        Next <span class="material-symbols-outlined fs-6 align-middle">chevron_right</span>
    </button>
    @endif
</div>
@endif