@php
    use Illuminate\Support\Str;

    // Ambil semua media dari field Images (gambar)
    $images = array_values($item->images ?? []);

    // ====== Tambah VIDEO dari custom field "Video" (atau "video") ======
    $videoRaw = optional(
        collect($item->customFields ?? [])->first(function ($f) {
            return Str::lower($f->name) === 'video'; // nama field: Video
        })
    )->value;

    // Normalisasi: dukung "storage/..." atau full URL
    $videoUrl = null;
    if ($videoRaw) {
        $videoUrl = Str::startsWith($videoRaw, ['storage/', '/storage/'])
            ? RvMedia::url($videoRaw)
            : $videoRaw;

        // PERBAIKAN: Masukkan video ke array images dengan penanda khusus
        // Tambahkan di awal array agar video jadi item pertama
        array_unshift($images, ['url' => $videoUrl, 'type' => 'video']);
    }
    // ================================================================

    $images       = array_values($images);
    $numberImages = count($images);
@endphp

@if ($numberImages)
<div class="container-fluid">
    <div class="mt-4 md:flex">
        {{-- Kolom kiri: item pertama (bisa gambar atau video) --}}
        <div class="@if ($numberImages > 1) lg:w-2/3 md:w-2/3 @else w-full @endif p-1">
            {!! Theme::partial('real-estate.properties.slider-image', [
                'property' => $item,
                'image'    => $images[0],
            ]) !!}
        </div>

        @if ($numberImages == 2)
            <div class="p-1 lg:w-1/3 md:w-1/3">
                {!! Theme::partial('real-estate.properties.slider-image', ['property' => $item, 'image' => $images[1]]) !!}
            </div>

        @elseif ($numberImages == 3)
            <div class="p-1 lg:w-1/3 md:w-1/3">
                <div class="grid grid-cols-2 md:grid-cols-none md:grid-rows-2 gap-1">
                    {!! Theme::partial('real-estate.properties.slider-image', ['property' => $item, 'image' => $images[1]]) !!}
                    {!! Theme::partial('real-estate.properties.slider-image', ['property' => $item, 'image' => $images[2]]) !!}
                </div>
            </div>

        @elseif ($numberImages == 4)
            <div class="p-1 lg:w-1/3 md:w-1/3">
                <div class="grid grid-cols-2 md:grid-cols-none md:grid-rows-2 gap-1">
                    {!! Theme::partial('real-estate.properties.slider-image', ['property' => $item, 'image' => $images[1]]) !!}
                    {!! Theme::partial('real-estate.properties.slider-image', ['property' => $item, 'image' => $images[2], 'mores' => 3]) !!}
                </div>
            </div>

        @elseif ($numberImages > 4)
            <div class="p-1 lg:w-1/2 md:w-1/2">
                <div class="grid grid-cols-2 gap-1 h-full">
                    @foreach (range(1, 4) as $i)
                        {!! Theme::partial('real-estate.properties.slider-image', [
                            'property' => $item,
                            'image'    => $images[$i],
                            'mores'    => $i === 4 ? $numberImages : 0,
                        ]) !!}
                    @endforeach
                </div>
            </div>

            {{-- sisanya hidden untuk lightbox --}}
            @foreach ($images as $k => $img)
                @if ($k > 4)
                    {!! Theme::partial('real-estate.properties.slider-image', ['property' => $item, 'image' => $img, 'hidden' => true]) !!}
                @endif
            @endforeach
        @endif
    </div>
</div>
@endif