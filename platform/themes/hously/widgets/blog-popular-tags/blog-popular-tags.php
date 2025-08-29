<?php

use Botble\Widget\AbstractWidget;

class BlogPopularTagsWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Blog popular tags'),
            'description' => __('Blog popular tags widget.'),
            'number_display' => 5,
        ]);
    }
}
