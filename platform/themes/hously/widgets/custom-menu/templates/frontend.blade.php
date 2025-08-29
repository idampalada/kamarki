<div class="lg:col-span-2 md:col-span-3">
    <div class="tracking-[1px] text-gray-100 font-semibold">{{ Arr::get($config, 'name') }}</div>
    <ul class="mx-0 mt-6 mb-0 list-none footer-list">
        {!!
            Menu::generateMenu([
                'slug' => Arr::get($config, 'menu_id'),
                'view' => 'footer-menu'
            ])
        !!}
    </ul>
</div>
