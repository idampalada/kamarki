<div>
    <label for="choices-bedrooms-{{ $type }}" class="font-medium form-label text-slate-900 dark:text-white">{{ __('Bedrooms:') }}</label>
    <div class="relative mt-2 filter-search-form filter-border">
        <i class="mdi mdi-currency-usd icons"></i>
        <select data-trigger name="bedroom" id="choices-bedrooms-{{ $id ?? $type }}" aria-label="{{ __('Bedrooms') }}">
            <option value="">{{ __('All Bedrooms') }}</option>
            @foreach(range(1, 5) as $i)
                <option value="{{ $i }}">@if($i !== 5)
                        {{ trans_choice(__('1 bedroom|:number bedrooms'), $i, ['number' => $i]) }}
                    @else
                        {{ __('5+ bedrooms') }}
                    @endif</option>
            @endforeach
        </select>
    </div>
</div>
