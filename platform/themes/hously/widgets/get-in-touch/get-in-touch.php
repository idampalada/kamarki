<?php

use Botble\Widget\AbstractWidget;

class GetInTouch extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Get In Touch.'),
            'description' => __('Have question? Get in touch!'),
            'title' => null,
            'button_label' => __('Contact'),
            'button_url' => '#',
        ]);
    }
}
