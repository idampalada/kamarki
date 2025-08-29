<?php

use Botble\Base\Facades\MetaBox;
use Botble\Base\Forms\FormAbstract;
use Botble\Media\Facades\RvMedia;
use Botble\Page\Models\Page;
use Botble\RealEstate\Models\Account;
use Botble\Theme\Facades\Theme;
use Botble\Base\Facades\Form;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Botble\Base\Forms\FormHelper;
use Theme\Hously\Forms\Fields\ThemeIconField;

register_page_template([
    'default' => __('Default'),
    'article' => __('Article'),
    'empty' => __('Empty'),
    'hero' => __('Hero'),
]);

register_sidebar([
    'id' => 'pre_footer',
    'name' => 'Pre Footer',
    'description' => 'Widgets at the bottom of the page.',
]);

register_sidebar([
    'id' => 'footer_menu',
    'name' => __('Footer Menu'),
    'description' => __('Footer Menu for Hously theme.'),
]);

register_sidebar([
    'id' => 'blog_sidebar',
    'name' => __('Blog Sidebar'),
    'description' => __('Blog sidebar.'),
]);

RvMedia::setUploadPathAndURLToPublic();

RvMedia::addSize('small', 600, 400)
    ->addSize('medium', 600, 600);

add_filter(BASE_FILTER_BEFORE_RENDER_FORM, function (FormAbstract $form, ?Model $data) {
    switch (get_class($data)) {
        case Account::class:
            $form
                ->addAfter('email', 'social_facebook', 'text', [
                    'label' => __('Social link Facebook'),
                    'label_attr' => ['class' => 'control-label'],
                    'value' => MetaBox::getMetaData($data, 'social_facebook', true),
                ])
                ->addAfter('email', 'social_linkedin', 'text', [
                    'label' => __('Social link Linkedin'),
                    'label_attr' => ['class' => 'control-label'],
                    'value' => MetaBox::getMetaData($data, 'social_linkedin', true),
                ])
                ->addAfter('email', 'social_instagram', 'text', [
                    'label' => __('Social link Instagram'),
                    'label_attr' => ['class' => 'control-label'],
                    'value' => MetaBox::getMetaData($data, 'social_instagram', true),
                ]);

            break;
        case Page::class:
            $form
                ->add('cover_image', 'mediaImage', [
                    'label' => __('Cover Image'),
                    'label_attr' => ['class' => 'control-label'],
                    'value' => MetaBox::getMetaData($data, 'cover_image', true),
                ])
                ->addAfter('template', 'navbar_style', 'customSelect', [
                    'label' => __('Navbar style'),
                    'label_attr' => ['class' => 'control-label'],
                    'choices' => ['light' => __('Light'), 'dark' => __('Dark')],
                    'selected' => MetaBox::getMetaData($data, 'navbar_style', true),
                ]);

            break;
    }

    return $form;
}, 120, 3);

add_action([BASE_ACTION_AFTER_CREATE_CONTENT, BASE_ACTION_AFTER_UPDATE_CONTENT], function (string $screen, Request $request, $data): void {
    if ($data instanceof Account && $request->has('social_facebook')) {
        MetaBox::saveMetaBoxData($data, 'social_facebook', $request->input('social_facebook'));
    }
    if ($data instanceof Account && $request->has('social_linkedin')) {
        MetaBox::saveMetaBoxData($data, 'social_linkedin', $request->input('social_linkedin'));
    }
    if ($data instanceof Account && $request->has('social_instagram')) {
        MetaBox::saveMetaBoxData($data, 'social_instagram', $request->input('social_instagram'));
    }
    if ($data instanceof Page && $request->has('cover_image')) {
        MetaBox::saveMetaBoxData($data, 'cover_image', $request->input('cover_image'));
    }
    if ($data instanceof Page && $request->has('navbar_style')) {
        MetaBox::saveMetaBoxData($data, 'navbar_style', $request->input('navbar_style'));
    }
}, 120, 3);

add_action('update_account_settings', function (Account $account) {
    foreach (['facebook', 'linkedin', 'instagram'] as $social) {
        MetaBox::saveMetaBoxData($account, 'social_' . $social, request()->input('social_' . $social));
    }
}, 120);

add_filter('form_custom_fields', function (FormAbstract $form, FormHelper $formHelper) {
    if (! $formHelper->hasCustomField('themeIcon')) {
        $form->addCustomField('themeIcon', ThemeIconField::class);
    }

    return $form;
}, 29, 2);

Form::component('themeIcon', Theme::getThemeNamespace('partials.forms.fields.icons-field'), [
    'name',
    'value' => null,
    'attributes' => [],
]);

app()->booted(function () {
    if (setting('social_login_enable', false)) {
        remove_filter(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM);

        add_filter(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM, function ($html) {
            Theme::asset()->usePath(false)->add('social-login-css', asset('vendor/core/plugins/social-login/css/social-login.css'), [], [], '1.0.0');

            if (Route::currentRouteName() === 'access.login') {
                return $html . view('plugins/social-login::login-options')->render();
            }

            return $html . Theme::partial('login-options');
        }, 25);
    }

    add_filter('account_settings_page', function (?string $html, Account $account) {
        return view(Theme::getThemeNamespace('views.real-estate.account.includes.social-links'), compact('account'))->render();
    }, 127, 2);
});
