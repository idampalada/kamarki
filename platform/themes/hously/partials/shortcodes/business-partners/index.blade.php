<section class="pt-10">
    <div class="container">
        <div class="grid md:grid-cols-6 grid-cols-2 justify-center gap-[30px]">
            @foreach(range(1, 10) as $i)
                @if($logo = $shortcode->{'logo_' . $i})
                    <div class="py-4 mx-auto">
                        <a href="{{ $shortcode->{'url_' . $i} }}">
                            <img src="{{ RvMedia::getImageUrl($logo) }}" class="h-6" alt="{{ $shortcode->{'name_' . $i} }}">
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
