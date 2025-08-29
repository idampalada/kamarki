<div class="absolute z-10 hidden w-full" id="location-suggestion">
    <ul class="p-0 m-0 list-none bg-white rounded-md shadow-md dark:bg-slate-900">
        @foreach($locations as $location)
            <li class="px-5 py-2.5 transition-all hover:bg-gray-100 hover:text-primary cursor-pointer dark:text-white dark:hover:bg-slate-800" data-location="{{ $location->name }}, {{ $location->state->name }}">
                {{ $location->name }}, {{ $location->state->name }}
            </li>
        @endforeach
    </ul>
</div>
