@if (is_plugin_active('blog'))
    @php
        $limit = (int) Arr::get($config, 'limit');
        $type = Arr::get($config, 'type');

        if ($limit > 0) {
            $tags = get_popular_tags($limit);
        } else {
            $tags = get_all_tags();
        }
    @endphp

    @if ($tags->count())
        <div class="p-6 bg-white rounded-lg shadow dark:bg-slate-800">
            <h3 class="text-xl font-medium">{{ Arr::get($config, 'name') }}</h3>
            <div class="pt-5 mt-4 border-t">
                <div class="flex flex-wrap gap-3">
                    @foreach($tags as $tag)
                        <a href="{{ $tag->url }}" class="bg-primary text-white hover:bg-secondary rounded-lg px-3 py-1.5">{{ $tag->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endif
