@if (is_plugin_active('blog'))
    <div>
        <form action="{{ route('public.search') }}" class="relative">
            <input type="text" class="px-4 py-6 rounded-lg form-input focus:border-slate-200 dark:bg-slate-900" name="q" placeholder="{{ __('Enter keyword...') }}" value="{{ BaseHelper::stringify(request()->query('q')) }}">
            <button type="submit" class="absolute h-full px-3 text-xl text-slate-700 end-0"><i class="mdi mdi-magnify"></i></button>
        </form>
    </div>
@endif
