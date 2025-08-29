<?php

app()->booted(function () {
    $layouts = [
        'grid' => __('Grid'),
        'list' => __('List'),
    ];

    theme_option()
        ->setSection([
            'title' => __('Social Links'),
            'desc' => __('Social Links at the footer.'),
            'id' => 'opt-text-subsection-social-links',
            'subsection' => true,
            'icon' => 'fas fa-icons',
            'fields' => [
                [
                    'id' => 'social_links',
                    'type' => 'repeater',
                    'label' => __('Social Links'),
                    'attributes' => [
                        'name' => 'social_links',
                        'value' => null,
                        'fields' => [
                            [
                                'type' => 'text',
                                'label' => __('Name'),
                                'attributes' => [
                                    'name' => 'social-name',
                                    'value' => null,
                                    'options' => [
                                        'class' => 'form-control',
                                    ],
                                ],
                            ],
                            [
                                'type' => 'themeIcon',
                                'label' => __('Icon'),
                                'attributes' => [
                                    'name' => 'social-icon',
                                    'value' => null,
                                    'options' => [
                                        'class' => 'form-control',
                                    ],
                                ],
                            ],
                            [
                                'type' => 'text',
                                'label' => __('URL'),
                                'attributes' => [
                                    'name' => 'social-url',
                                    'value' => null,
                                    'options' => [
                                        'class' => 'form-control',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ])
        ->setField([
            'id' => 'authentication_background_image',
            'section_id' => 'opt-text-subsection-real-estate',
            'type' => 'mediaImage',
            'label' => __('Authentication background image'),
            'attributes' => [
                'name' => 'authentication_background_image',
                'value' => null,
            ],
        ])
        ->setField([
            'id' => 'categories_background_image',
            'section_id' => 'opt-text-subsection-real-estate',
            'type' => 'mediaImage',
            'label' => __('Categories background image'),
            'attributes' => [
                'name' => 'categories_background_image',
                'value' => null,
            ],
        ])
        ->setField([
            'id' => 'authentication_enable_snowfall_effect',
            'section_id' => 'opt-text-subsection-real-estate',
            'type' => 'onOff',
            'label' => __('Authentication Enable Snowfall effect?'),
            'attributes' => [
                'name' => 'authentication_enable_snowfall_effect',
                'value' => null,
            ],
        ])
        ->setField([
            'id' => 'logo_authentication_page',
            'section_id' => 'opt-text-subsection-real-estate',
            'type' => 'mediaImage',
            'label' => __('Logo authentication page'),
            'attributes' => [
                'name' => 'logo_authentication_page',
                'value' => '',
            ],
        ])
        ->setField([
            'id' => 'copyright',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'text',
            'label' => __('Copyright'),
            'attributes' => [
                'name' => 'copyright',
                'value' => __('© :year Your Company. All right reserved.', ['year' => now()->format('Y')]),
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => __('Change copyright'),
                    'data-counter' => 250,
                ],
            ],
            'helper' => __('Copyright on footer of site'),
        ])
        ->setField([
            'id' => 'primary_font',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'googleFonts',
            'label' => __('Primary font'),
            'attributes' => [
                'name' => 'primary_font',
                'value' => 'League Spartan',
            ],
        ])
        ->setField([
            'id' => 'primary_color',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'customColor',
            'label' => __('Primary color'),
            'attributes' => [
                'name' => 'primary_color',
                'value' => '#16a34a',
            ],
        ])
        ->setField([
            'id' => 'secondary_color',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'customColor',
            'label' => __('Secondary color'),
            'attributes' => [
                'name' => 'secondary_color',
                'value' => '#15803D',
            ],
        ])
        ->setField([
            'id' => 'logo_dark',
            'section_id' => 'opt-text-subsection-logo',
            'type' => 'mediaImage',
            'label' => __('Logo dark'),
            'attributes' => [
                'name' => 'logo_dark',
                'value' => '',
            ],
        ])
        ->setField([
            'id' => 'default_page_cover_image',
            'section_id' => 'opt-text-subsection-page',
            'type' => 'mediaImage',
            'label' => __('Cover Image'),
            'attributes' => [
                'name' => 'default_page_cover_image',
                'value' => '',
            ],
        ])
        ->setField([
            'id' => 'properties_list_layout',
            'section_id' => 'opt-text-subsection-real-estate',
            'type' => 'customSelect',
            'label' => __('Properties List layout'),
            'attributes' => [
                'name' => 'properties_list_layout',
                'list' => $layouts,
                'value' => 'grid',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id' => 'projects_list_layout',
            'section_id' => 'opt-text-subsection-real-estate',
            'type' => 'customSelect',
            'label' => __('Projects List layout'),
            'attributes' => [
                'name' => 'projects_list_layout',
                'list' => $layouts,
                'value' => 'grid',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id' => 'enabled_toggle_theme_mode',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'onOff',
            'label' => __('Enable toggle theme mode?'),
            'attributes' => [
                'name' => 'enabled_toggle_theme_mode',
                'value' => null,
            ],
        ])
        ->setField([
            'id' => 'default_theme_mode',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'customSelect',
            'label' => __('Default theme mode'),
            'attributes' => [
                'name' => 'default_theme_mode',
                'list' => [
                    'light' => __('Light'),
                    'dark' => __('Dark'),
                    'system' => __('System'),
                ],
                'value' => 'system',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id' => '404_page_image',
            'section_id' => 'opt-text-subsection-page',
            'type' => 'mediaImage',
            'label' => __('404 page image'),
            'attributes' => [
                'name' => '404_page_image',
                'value' => '',
            ],
        ]);
});
