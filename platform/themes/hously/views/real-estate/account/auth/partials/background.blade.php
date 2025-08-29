@if ($backgroundImage = theme_option('authentication_background_image'))
    <div class="absolute inset-0 bg-center bg-cover bg-no-repeat image-wrap z-1" style="background-image: url('{{ RvMedia::getImageUrl($backgroundImage) }}')"></div>
@endif
