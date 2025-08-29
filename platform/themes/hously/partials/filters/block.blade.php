<div>
    <label for="choices-blocks-{{ $type }}" class="font-medium form-label text-slate-900 dark:text-white">{{ __('Blocks:') }}</label>
    <div class="relative mt-2 filter-search-form filter-border">
        <i class="mdi mdi-currency-usd icons"></i>
        <select data-trigger name="blocks" id="choices-blocks-{{ $id ?? $type}}" aria-label="{{ __('Blocks') }}">
            <option value="">{{ __('All Blocks') }}</option>
            @foreach(range(1, 5) as $i)
                <option value="{{ $i }}">@if($i !== 5)
                        {{ trans_choice(__('1 block|:number blocks'), $i, ['number' => $i]) }}
                    @else
                        {{ __('5+ blocks') }}
                    @endif</option>
            @endforeach
        </select>
    </div>
</div>
