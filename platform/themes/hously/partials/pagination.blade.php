@if ($paginator->hasPages())
    <div class="grid grid-cols-1 mt-8 md:grid-cols-12" id="pagination">
        <div class="text-center md:col-span-12">
            <nav>
                <ul class="inline-flex items-center p-0 m-0 -space-x-px list-none">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li>
                            <span class="inline-flex items-center justify-center w-10 h-10 mx-1 bg-white rounded-full shadow-sm cursor-default text-slate-400 dark:bg-slate-900 dark:shadow-gray-700" aria-disabled="true" aria-label="{{ __('pagination.previous') }}" aria-hidden="true">
                                <i class="mdi mdi-chevron-left text-5px rtl:rotate-180"></i>
                            </span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $paginator->previousPageUrl() }}" aria-label="{{ __('pagination.previous') }}" class="inline-flex items-center justify-center w-10 h-10 mx-1 bg-white rounded-full shadow-sm text-slate-400 dark:bg-slate-900 hover:text-white dark:shadow-gray-700 hover:border-primary dark:hover:border-primary hover:bg-primary dark:hover:bg-primary">
                                <i class="mdi mdi-chevron-left text-5px rtl:rotate-180"></i>
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li>
                                <span class="inline-flex items-center justify-center w-10 h-10 mx-1 bg-white rounded-full shadow-sm cursor-default text-slate-400 dark:bg-slate-900 dark:shadow-gray-700" aria-disabled="true">
                                    {{ $element }}
                                </span>
                            </li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li>
                                        <span aria-current="page" class="z-10 inline-flex items-center justify-center w-10 h-10 mx-1 text-white rounded-full shadow-sm cursor-default bg-primary dark:shadow-gray-700">{{ $page }}</a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ $url }}" class="inline-flex items-center justify-center w-10 h-10 mx-1 bg-white rounded-full shadow-sm text-slate-400 hover:text-white dark:bg-slate-900 dark:shadow-gray-700 hover:border-primary dark:hover:border-primary hover:bg-primary dark:hover:bg-primary" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li>
                            <a href="{{ $paginator->nextPageUrl() }}" aria-label="{{ __('pagination.next') }}" class="inline-flex items-center justify-center w-10 h-10 mx-1 bg-white rounded-full shadow-sm text-slate-400 dark:bg-slate-900 hover:text-white dark:shadow-gray-700 hover:border-primary dark:hover:border-primary hover:bg-primary dark:hover:bg-primary">
                                <i class="mdi mdi-chevron-right text-5px rtl:rotate-180"></i>
                            </a>
                        </li>
                    @else
                        <li>
                            <span class="inline-flex items-center justify-center w-10 h-10 mx-1 bg-white rounded-full shadow-sm cursor-default text-slate-400 dark:bg-slate-900 dark:shadow-gray-700" aria-disabled="true" aria-label="{{ __('pagination.next') }}" aria-hidden="true">
                                <i class="mdi mdi-chevron-right text-5px rtl:rotate-180"></i>
                            </span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
@endif
