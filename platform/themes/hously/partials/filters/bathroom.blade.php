<div>
    <label for="choices-bathrooms-{{ $type }}" class="font-medium form-label text-slate-900 dark:text-white">{{ __('Bathrooms:') }}</label>
    <div class="relative mt-2 filter-search-form filter-border">
        <i class="mdi mdi-currency-usd icons"></i>
        <select data-trigger name="bathroom" id="choices-bathrooms-{{ $id ?? $type }}" aria-label="{{ __('Bathrooms') }}">
            <option value="">{{ __('All Bathrooms') }}</option>
            @foreach(range(1, 5) as $i)
                <option value="{{ $i }}">@if($i !== 5)
                        {{ trans_choice(__('1 bathroom|:number bathrooms'), $i, ['number' => $i]) }}
                    @else
                        {{ __('5+ bathrooms') }}
                    @endif</option>
            @endforeach
        </select>
    </div>
</div>
