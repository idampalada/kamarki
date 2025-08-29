@php(Theme::set('navStyle', 'light'))

{!! Theme::partial('header') !!}

{!! Theme::partial('breadcrumb') !!}

<section class="relative py-16 lg:py-24">
    <div class="container">
        <div class="justify-center md:flex">
            <div class="md:w-3/4">
                <div class="p-6 bg-white rounded-md shadow dark:bg-slate-900 dark:shadow-gray-700">
                    {!! Theme::content() !!}
                </div>
            </div>
        </div>
    </div>
</section>

{!! Theme::partial('footer') !!}
