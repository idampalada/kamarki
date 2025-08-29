<?php

use Botble\Widget\AbstractWidget;

class BlogPopularCategoriesWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Blog popular categories'),
            'description' => __('Blog popular categories widget.'),
            'number_display' => 5,
        ]);
    }
}
