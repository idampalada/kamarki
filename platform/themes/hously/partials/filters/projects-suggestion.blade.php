<div class="absolute z-10 hidden w-full" id="projects-suggestion">
    <ul class="p-0 m-0 list-none bg-white rounded-md shadow-md dark:bg-slate-900">
        @foreach($projects as $project)
            <li class="px-5 py-2.5 transition-all hover:bg-gray-100 hover:text-primary cursor-pointer dark:text-white dark:hover:bg-slate-800" data-project="{{ $project->name }}">
                {{ $project->name }}
            </li>
        @endforeach
    </ul>
</div>
