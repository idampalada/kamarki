<section class="relative py-16 lg:py-24">
    <div class="container">
        <div class="grid md:grid-cols-12 grid-cols-1 items-center gap-[30px]">
            <div class="lg:col-span-7 md:col-span-6">
                <img src="{{ $shortcode->background_image ? RvMedia::getImageUrl($shortcode->background_image) : Theme::asset()->url('images/svg/contact.svg') }}" alt="{!! BaseHelper::clean($shortcode->title) !!}">
            </div>

            <div class="lg:col-span-5 md:col-span-6">
                <div class="lg:ms-5">
                    <div class="p-6 bg-white rounded-md shadow dark:bg-slate-900 dark:shadow-gray-700">
                        <h3 class="mb-6 text-2xl font-medium leading-normal">{!! BaseHelper::clean($shortcode->title) !!}</h3>

                        <form method="post" action="{{ route('public.send.contact') }}" class="contact-form">
                            @csrf
                            <p class="mb-0" id="error-msg"></p>
                            <div id="simple-msg"></div>
                            <div class="grid lg:grid-cols-12 lg:gap-6">
                                <div class="mb-5 lg:col-span-6">
                                    <label for="name" class="font-medium">{{ __('Your Name:') }}</label>
                                    <input name="name" id="name" type="text" class="mt-2 form-input" placeholder="{{ __('Name:') }}">
                                </div>

                                <div class="mb-5 lg:col-span-6">
                                    <label for="email" class="font-medium">{{ __('Your Email:') }}</label>
                                    <input name="email" id="email" type="email" class="mt-2 form-input" placeholder="{{ __('Email:') }}">
                                </div>
                            </div>

                            <div class="grid grid-cols-1">
                                <div class="mb-5">
                                    <label for="subject" class="font-medium">{{ __('Your Question:') }}</label>
                                    <input name="subject" id="subject" class="mt-2 form-input" placeholder="{{ __('Subject:') }}">
                                </div>

                                <div class="mb-5">
                                    <label for="content" class="font-medium">{{ __('Your Comment:') }}</label>
                                    <textarea name="content" id="content" class="mt-2 form-input textarea" placeholder="{{ __('Message:') }}"></textarea>
                                </div>
                            </div>

                            @if (is_plugin_active('captcha'))
                                @if (Captcha::isEnabled())
                                    <div class="grid grid-cols-1">
                                        <div class="mb-5">
                                            {!! Captcha::display() !!}
                                        </div>
                                    </div>
                                @endif

                                @if (setting('enable_math_captcha_for_contact_form', 0))
                                    <div class="grid grid-cols-1">
                                        <div class="mb-5">
                                            <label for="subject" class="font-medium">{{ app('math-captcha')->label() }}</label>
                                            {!! app('math-captcha')->input(['class' => 'mt-2 form-input', 'id' => 'math-group']) !!}
                                        </div>
                                    </div>
                                @endif
                            @endif

                            {!! apply_filters('after_contact_form', null) !!}

                            <div class="contact-form-group">
                                <div class="contact-message contact-success-message" style="display: none"></div>
                                <div class="contact-message contact-error-message" style="display: none"></div>
                            </div>
                            <br>
                            <button type="submit" id="submit" class="text-white rounded-md btn bg-primary hover:bg-secondary" style="background-color: #00adee !important;">{{ __('Send Message') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><
</section>
