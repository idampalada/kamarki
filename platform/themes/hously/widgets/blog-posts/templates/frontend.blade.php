@if (is_plugin_active('blog'))
    @php
        $limit = (int) Arr::get($config, 'limit');
        $type = Arr::get($config, 'type');

        $posts = match ($type) {
            'recent' => get_recent_posts($limit),
            default => get_popular_posts($limit),
        };
    @endphp
    @if ($posts->count())
        <div class="p-6 bg-white rounded-lg shadow dark:bg-slate-800">
            <h3 class="text-xl font-medium">{{ Arr::get($config, 'name') }}</h3>
            <div class="pt-5 mt-4 space-y-4 border-t">
                @foreach($posts as $post)
                    <div class="flex flex-start">
                        <a href="{{ $post->url }}">
                            <img src="{{ RvMedia::getImageUrl($post->image, 'small', false, RvMedia::getDefaultImage()) }}" alt="{{ $post->name }}" class="max-w-[90px] rounded">
                        </a>
                        <div class="ms-3">
                            <a href="{{ $post->url }}" class="transition-all hover:text-primary line-clamp-2">
                                <h5>{!! BaseHelper::clean($post->name) !!}</h5>
                            </a>
                            <div class="text-sm text-slate-500">
                                <i class="mdi mdi-calendar-outline"></i>
                                <span>{{ $post->created_at->translatedFormat('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endif
