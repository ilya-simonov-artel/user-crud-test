@if ($paginator->hasPages())
    <nav class="mt-6 flex flex-wrap items-center justify-center gap-2 text-sm" role="navigation" aria-label="Pagination">
        @if ($paginator->onFirstPage())
            <span class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-slate-400" aria-disabled="true">&laquo; Prev</span>
        @else
            <a class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-slate-700 shadow-sm hover:border-slate-300" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo; Prev</a>
        @endif

        <span class="rounded-lg border border-slate-200 bg-slate-100 px-3 py-2 text-slate-700">
            Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}
        </span>

        @if ($paginator->hasMorePages())
            <a class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-slate-700 shadow-sm hover:border-slate-300" href="{{ $paginator->nextPageUrl() }}" rel="next">Next &raquo;</a>
        @else
            <span class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-slate-400" aria-disabled="true">Next &raquo;</span>
        @endif
    </nav>
@endif

