@php($popularPosts = get_popular_posts(3))

<div class="container mt-16 lg:mt-24">
    <div class="grid grid-cols-1 md:grid-cols-6 md:gap-10">
        <div class="col-span-1 mb-16 md:col-span-4 md:mb-0">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                @foreach($posts as $post)
                    {!! Theme::partial('blog.post-item', compact('post')) !!}
                @endforeach
            </div>

            {{ $posts->links(Theme::getThemeNamespace('partials.pagination')) }}
        </div>
        <div class="col-span-2 space-y-12">
            {!! dynamic_sidebar('blog_sidebar') !!}
        </div>
    </div>
</div>
