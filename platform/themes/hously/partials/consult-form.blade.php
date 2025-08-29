<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

@if (auth('account')->check())
    <form
        class="generic-form"
        id="contact-form"
        method="post"
        action="{{ route('public.send.consult') }}">
        @csrf
        <input type="hidden" value="{{ $type }}" name="type">
        <input type="hidden" value="{{ $data->id }}" name="data_id">
        <div class="p-6 space-y-3">
            <h3 class="mb-4 text-xl font-bold">{{ __('Contact') }}</h3>
            <div>
                <input name="name" type="text" class="bg-white form-input dark:bg-slate-700"
                    placeholder="{{ __('Name') }}">
            </div>
            <div>
                <input name="phone" type="text" class="bg-white form-input dark:bg-slate-700"
                    placeholder="{{ __('Phone') }}">
            </div>
            <div>
                <input name="email" type="email" class="bg-white form-input dark:bg-slate-700"
                    placeholder="{{ __('Email') }}">
            </div>
            <div>
                <input type="text" readonly class="text-gray-400 form-input" disabled value="{{ $data->name }}">
            </div>
            <div>
                <input name="date" id="datePicker" type="text" class="bg-white form-input dark:bg-slate-700"
                    placeholder="{{ __('Select Date') }}">
            </div>
            <div class="hidden">
                <textarea
                    name="content"
                    rows="3"
                    class="form-input h-24 dark:bg-slate-700"
                    placeholder="Tulis pesan yang ingin disampaikan">Halo, saya ingin memesan "{{ $data->name }}"
                </textarea>
            </div>
            @if (setting('enable_captcha') && is_plugin_active('captcha'))
                <div>
                    {!! Captcha::display() !!}
                </div>
            @endif
            <div>
                <button type="submit" id="submitConsultation" class="w-full text-white btn bg-primary">{{ __('Rent now') }}</button>
            </div>
            <div class="clearfix"></div>

            {!! apply_filters('consult_form_extra_info', null, $data) !!}
            <br>
        </div>
    </form>

    <script>
        document
            .getElementById('submitConsultation')
            .addEventListener('click', function (e) {
                var contentVal = document.querySelector('textarea[name="content"]').value;
                var message = encodeURIComponent(contentVal);
                var waUrl   = `https://wa.me/+6285283515660?text=${message}`;
                window.open(waUrl, '_blank');
            });
    </script>
@else
    <div>
        <a href="{{ auth('account')->check() ? '' : route('public.account.login') }}" type="submit"
            class="w-full text-white btn bg-primary">{{ __('Login to Book Property') }}</a>
    </div>
@endif
<script>
    document.addEventListener("DOMContentLoaded", function() {
        flatpickr("#datePicker", {
            enableTime: false, // Set to true if you need time picker as well
            dateFormat: "d M Y", // Customize the date format
            onChange: function(selectedDates, dateStr, instance) {
                // You can handle the date change event here if needed
                const contentField = document.querySelector('textarea[name="content"]');
                contentField.value = `Halo, saya ingin memesan "{{ $data->name }}" pada tanggal ${dateStr}`;
            },
        });
    });
</script>
