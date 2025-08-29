@if (is_plugin_active('blog'))
    @php
        $limit = (int) Arr::get($config, 'limit');
        $type = Arr::get($config, 'type');

        if ($limit > 0) {
            $categories = get_popular_categories($limit);
        } else {
            $categories = get_all_categories();
        }
    @endphp

    @if ($categories->count())
        <div class="p-6 bg-white rounded-lg shadow dark:bg-slate-800">
            <h3 class="text-xl font-medium">{{ Arr::get($config, 'name') }}</h3>
            <div class="pt-5 mt-4 border-t">
                <ul class="space-y-2">
                    @foreach($categories as $category)
                        <li class="transition-all duration-200 hover:text-primary">
                            <i class="mdi mdi-chevron-right"></i>
                            <a href="{{ $category->url }}" class="font-medium">{{ $category->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
@endif
