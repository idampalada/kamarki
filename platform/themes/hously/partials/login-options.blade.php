@if (SocialService::hasAnyProviderEnable())
    <div class="pt-5 mt-5 text-center border-t">
        <p class="mb-2  text-slate-500">{{ __('Login with social networks') }}</p>
        <ul class="social-icons">
            @foreach (SocialService::getProviderKeys() as $item)
                @if (SocialService::getProviderEnabled($item))
                    <li>
                        <a class="social-icon-color {{ $item }}" data-bs-toggle="tooltip" data-bs-original-title="{{ $item }}"
                           href="{{ route('auth.social', isset($params) ? array_merge([$item], $params) : $item) }}"></a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
@endif
