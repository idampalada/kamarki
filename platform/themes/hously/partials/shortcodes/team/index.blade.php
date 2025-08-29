<section class="relative py-16 lg:py-24">
    <div class="container">
        <div class="grid grid-cols-1 pb-8 text-center">
            <h3 class="mb-4 text-2xl font-semibold leading-normal md:text-3xl md:leading-normal">{!! BaseHelper::clean($shortcode->title) !!}</h3>

            <p class="max-w-xl mx-auto text-slate-400">{!! BaseHelper::clean($shortcode->subtitle) !!}</p>
        </div>

        @if (! empty($teams))
            <div class="grid md:grid-cols-12 grid-cols-1 mt-8 gap-[30px]">
                @foreach($teams as $team)
                    <div class="lg:col-span-3 md:col-span-6">
                        <div class="text-center group">
                            <div class="relative inline-block mx-auto overflow-hidden rounded-full h-52 w-52">
                                <img src="{{ RvMedia::getImageUrl($team->avatar_url, 'medium') }}" class="w-full" alt="{{ $team->name }}" />
                                <div class="absolute inset-0 transition-all duration-500 ease-in-out rounded-full opacity-0 bg-gradient-to-b from-transparent to-black h-52 w-52 group-hover:opacity-100"></div>

                                <ul class="absolute start-0 end-0 p-0 m-0 list-none transition-all duration-500 ease-in-out -bottom-20 group-hover:bottom-5">
                                    @if ($facebook = $team->getMetaData('social_facebook', true))
                                        <li class="inline"><a href="{{ $facebook }}" class="text-white border rounded-full btn btn-icon btn-sm border-primary bg-primary hover:border-primary hover:bg-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 feather feather-facebook"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg></a></li>
                                    @endif
                                    @if ($linkedin = $team->getMetaData('social_linkedin', true))
                                        <li class="inline"><a href="{{ $linkedin }}" class="text-white border rounded-full btn btn-icon btn-sm border-primary bg-primary hover:border-primary hover:bg-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 feather feather-instagram"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg></a></li>
                                    @endif
                                    @if ($instagram = $team->getMetaData('social_instagram', true))
                                        <li class="inline"><a href="{{ $instagram }}" class="text-white border rounded-full btn btn-icon btn-sm border-primary bg-primary hover:border-primary hover:bg-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 feather feather-linkedin"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg></a></li>
                                    @endif
                                </ul>
                            </div>

                            <div class="mt-3 content">
                                <a href="" class="text-xl font-medium transition-all duration-500 ease-in-out hover:text-primary">{{ $team->name }}</a>
                                @if ($team->company)
                                    <p class="text-slate-400">{{ $team->company }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
