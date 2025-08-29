<div class="overflow-hidden transition-all bg-white rounded-lg shadow-lg hover:shadow-2xl duration-400 dark:bg-slate-900 dark:border dark:border-slate-800">
    <div class="overflow-hidden">
        <a href="{{ $post->url }}">
            <img src="{{ RvMedia::getImageUrl($post->image, 'small', false, RvMedia::getDefaultImage()) }}" alt="{{ $post->name }}" class="w-full transition-all duration-300 hover:scale-110">
        </a>
    </div>
    <div class="p-6">
        <a href="{{ $post->url }}" class="text-lg transition-all hover:text-secondary">{!! BaseHelper::clean($post->name) !!}</a>
        <ul class="flex gap-3 ps-0 my-2 text-sm list-none text-slate-500 dark:text-slate-300">
            <li>
                <i class="mdi mdi-calendar-outline"></i>
                <span>{{ $post->created_at->translatedFormat('M d, Y') }}</span>
            </li>
            @if($post->firstCategory)
                <li>
                    <a href="{{ $post->firstCategory->url }}" class="text-sm hover:text-primary">
                        <i class="mdi mdi-tag-outline"></i>
                        <span>{{ $post->firstCategory->name }}</span>
                    </a>
                </li>
            @endif
            <li>
                <i class="mdi mdi-eye-outline"></i>
                <span>{{ number_format($post->views) }}</span>
            </li>
        </ul>
        <p class="mt-3 leading-6 text-slate-600 dark:text-slate-300" title="{{ $post->description }}">{{ Str::words($post->description, 20) }}</p>
    </div>
</div>
