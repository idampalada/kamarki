@if($shortcode->address)
    <div class="relative mt-20 google-map container-fluid">
        <div class="grid grid-cols-1">
            <div class="w-full leading-[0] border-0">
                <iframe src="https://maps.google.com/maps?q={{ addslashes($shortcode->address) }}%20&t=&z=13&ie=UTF8&iwloc=&output=embed" class="border-none w-full h-[500px]" allowfullscreen></iframe>
            </div>
        </div>
    </div>
@endif
