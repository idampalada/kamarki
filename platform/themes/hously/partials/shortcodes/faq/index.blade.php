<section class="relative pt-16 lg:pt-24">
    <div class="container">
        <div class="grid md:grid-cols-12 grid-cols-1 gap-[30px]">
            @if ($categories->count() > 1)
                <div class="lg:col-span-4 md:col-span-5">
                    <div class="sticky p-6 rounded-md shadow dark:shadow-gray-700 top-32">
                        <ul class="py-0 mb-0 space-y-2 list-unstyled sidebar-nav" id="navmenu-nav">
                            @foreach($categories as $category)
                                <li class="p-0 transition-all navbar-item hover:text-primary">
                                    <a href="#{{ Str::slug($category->name) }}" class="text-base font-medium no-underline navbar-link text-inherit">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div @class(['lg:col-span-8 md:col-span-7' => $categories->count() > 1, 'col-span-12' => $categories->count() <= 1])>
                @foreach($categories as $category)
                    <div id="{{ Str::slug($category->name) }}" @class(['mt-6' => ! $loop->first])>
                        <h5 class="text-2xl font-semibold">{{ $category->name }}</h5>

                        <div id="accordion-collapseone" data-accordion="collapse" class="mt-6">
                            @foreach($category->faqs as $faq)
                                <div class="relative mb-4 overflow-hidden rounded-md shadow dark:shadow-gray-700">
                                    <h2 class="text-lg font-medium" id="accordion-collapse-heading-{{ $faq->id }}">
                                        <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-dark dark:text-white" data-accordion-target="#accordion-collapse-{{ $faq->id }}" aria-expanded="false" aria-controls="accordion-collapse-{{ $faq->id }}">
                                            <span>{{ $faq->question }}</span>
                                            <svg data-accordion-icon="" class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </h2>
                                    <div id="accordion-collapse-{{ $faq->id }}" class="hidden" aria-labelledby="accordion-collapse-heading-{{ $faq->id }}">
                                        <div class="p-5">
                                            <p class="text-slate-400 dark:text-gray-400">{!! BaseHelper::clean($faq->answer) !!}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
