@if ($paginator->hasPages())
<div class="pagination-container">
    <div class="pagination-row d-flex justify-content-between align-items-center">
        <!-- Left Side: Showing entries info -->
        <div class="pagination-info d-flex align-items-center">
            <span>Showing <b>{{ $paginator->firstItem() }}</b> to <b>{{ $paginator->lastItem() }}</b> of <b>{{ $paginator->total() }}</b> entries</span>
        </div>
        
        <!-- Right Side: Per Page Selector -->
        <div class="per-page-selector d-flex align-items-center">
            <small class="me-1">Show</small>
            <select class="form-select form-select-sm mx-1" style="width: auto; min-width: 60px;">
                <option value="10" {{ request('per_page', 20) == 10 ? 'selected' : '' }}>10</option>
                <option value="20" {{ request('per_page', 20) == 20 ? 'selected' : '' }}>20</option>
                <option value="30" {{ request('per_page', 20) == 30 ? 'selected' : '' }}>30</option>
                <option value="50" {{ request('per_page', 20) == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('per_page', 20) == 100 ? 'selected' : '' }}>100</option>
            </select>
            <small class="ms-1">entries</small>
        </div>
    </div>
    
    <!-- Pagination Links - Centered on next line -->
    @if ($paginator->lastPage() > 1)
    <div class="pagination-links d-flex justify-content-center mt-2">
        <nav aria-label="Table pagination">
            <ul class="pagination pagination-sm modern-pagination mb-0">
                <!-- Previous Page Link -->
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link" aria-label="Previous">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                @endif

                <!-- Pagination Elements -->
                @foreach ($elements as $element)
                    <!-- "Three Dots" Separator -->
                    @if (is_string($element))
                        <li class="page-item disabled">
                            <span class="page-link dots">{{ $element }}</span>
                        </li>
                    @endif

                    <!-- Array Of Links -->
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                <!-- Next Page Link -->
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link" aria-label="Next">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
    @endif
</div>
@endif
