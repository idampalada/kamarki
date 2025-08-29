<section class="relative pt-16 lg:pt-24">
    <div class="container">
        <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-x-[30px] gap-y-[50px]">
            @foreach($packages as $package)
                <div class="duration-500 ease-in-out rounded-md shadow dark:shadow-gray-700 hover:shadow-md dark:hover:shadow-gray-700">
                    <div class="p-6 text-center border-b dark:border-gray-800">
                        @if($loop->first)
                            <div class="flex items-center justify-center w-24 h-24 mx-auto text-3xl rounded-full bg-primary/5 text-primary">
                                <i class="mdi mdi-tree-outline"></i>
                            </div>
                        @elseif($loop->last)
                            <div class="flex items-center justify-center w-24 h-24 mx-auto text-3xl rounded-full bg-primary/5 text-primary">
                                <i class="mdi mdi-rocket-outline"></i>
                            </div>
                        @else
                            <div class="flex items-center justify-center w-24 h-24 mx-auto text-3xl rounded-full bg-primary/5 text-primary">
                                <i class="mdi mdi-shield-outline"></i>
                            </div>
                        @endif
                        <h3 class="mt-4 text-2xl font-medium text-primary">{{ $package->name }}</h3>

                        <div class="flex justify-center mt-4">
                            <span class="text-3xl font-semibold">{{ format_price($package->price) }}</span>
                        </div>
                    </div>

                    <div class="p-6">
                        <ul class="p-0 m-0 list-none">
                            @if ($package->number_of_listings)
                                <li class="mt-2 text-slate-400"><span class="text-lg text-primary me-2"><i class="align-middle mdi mdi-check-circle"></i></span>{{ __(':number Listings', ['number' => $package->number_of_listings]) }}</li>
                            @endif
                            @if ($package->account_limit === 1)
                                <li class="mt-2 text-slate-400"><span class="text-lg text-primary me-2"><i class="align-middle mdi mdi-check-circle"></i></span>{{ __('Limited purchase by account') }}</li>
                            @elseif (! $package->account_limit)
                                <li class="mt-2 text-slate-400"><span class="text-lg text-primary me-2"><i class="align-middle mdi mdi-check-circle"></i></span>{{ __('Unlimited purchase by account') }}</li>
                            @endif
                        </ul>

                        <a href="{{ auth('account')->check() ? route('public.account.packages') : route('public.account.login') }}" class="w-full mt-4 text-white rounded-md btn bg-primary hover:bg-secondary border-primary dark:border-primary">{{ __('Get Started') }}</a>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
