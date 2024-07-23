<!-- resources/views/vendor/livewire/custom-pagination.blade.php -->
@if ($paginator->hasPages())
    <nav class="d-flex justify-content-between align-items-center">
        <div>
            {{-- Results Label --}}
            <span class="text-muted me-4 text-nowrap" style="font-size: 13px;">
                Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
            </span>
        </div>
        <div>
            <ul class="pagination mb-0">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <span class="page-link" aria-hidden="true">&lsaquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <button type="button" class="page-link" wire:click="previousPage" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</button>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" wire:key="paginator-page-{{ $page }}" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                            @elseif ($page == 1 || $page == $paginator->lastPage() || 
                                    ($page >= $paginator->currentPage() - 1 && $page <= $paginator->currentPage() + 1))
                                <li class="page-item" wire:key="paginator-page-{{ $page }}"><button type="button" class="page-link" wire:click="gotoPage({{ $page }})">{{ $page }}</button></li>
                            @elseif ($page == $paginator->currentPage() - 2 || $page == $paginator->currentPage() + 2)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <button type="button" class="page-link" wire:click="nextPage" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</button>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                        <span class="page-link" aria-hidden="true">&rsaquo;</span>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
@else
    <!-- Always show pagination controls even if there are no pages -->
    <nav class="d-flex justify-content-between align-items-center">
        <div>
            <span class="text-muted me-4 text-nowrap" style="font-size: 13px;">Showing 0 to 0 of 0 results</span>
        </div>
        <div>
            <ul class="pagination mb-0">
                <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
                <li class="page-item active"><span class="page-link">1</span></li>
                <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
            </ul>
        </div>
    </nav>
@endif
