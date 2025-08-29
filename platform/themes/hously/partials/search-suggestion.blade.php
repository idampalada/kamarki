<div class="absolute z-10 hidden w-full" id="keyword-suggestion">
    <ul class="p-0 m-0 overflow-auto list-none bg-white rounded-md shadow-md max-h-96 dark:bg-slate-900 dark:text-white">
        @foreach($items as $item)
            <li class="px-5 py-2.5 transition-all hover:bg-gray-100 hover:text-primary cursor-pointer dark:hover:bg-slate-800">
                <a href="{{ $item->url }}">{{ $item->name }}</a>
                @if($item->city->id)
                    <p>{{ $item->city->name }}, {{ $item->city->state->name }}</p>
                @endif
            </li>
        @endforeach
    </ul>
</div>
