<div>
    <label for="choices-floors-{{ $type }}" class="font-medium form-label text-slate-900 dark:text-white">{{ __('Floors:') }}</label>
    <div class="relative mt-2 filter-search-form filter-border">
        <i class="mdi mdi-currency-usd icons"></i>
        <select data-trigger name="floor" id="choices-floors-{{ $id ?? $type}}" aria-label="{{ __('Floors') }}">
            <option value="">{{ __('All Floors') }}</option>
            @foreach(range(1, 5) as $i)
                <option value="{{ $i }}">@if($i !== 5)
                        {{ trans_choice(__('1 floor|:number floors'), $i, ['number' => $i]) }}
                    @else
                        {{ __('5+ floors') }}
                    @endif</option>
            @endforeach
        </select>
    </div>
</div>
