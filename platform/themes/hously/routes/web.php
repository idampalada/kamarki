<?php

use Theme\Hously\Http\Controllers\HouslyController;

// Custom routes
Route::group(
    ['controller' => HouslyController::class, 'as' => 'public.', 'middleware' => ['web', 'core']],
    function () {
        Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {
            Route::get('ajax/cities', 'getAjaxCities')->name('ajax.cities');
            Route::get('ajax/featured-properties-for-map', 'ajaxGetPropertiesFeaturedForMap')->name('ajax.featured-properties-for-map');
            Route::get('ajax/properties/map', 'ajaxGetPropertiesForMap')->name('ajax.properties.map');
            Route::get('ajax/projects/map', 'ajaxGetProjectsForMap')->name('ajax.projects.map');
            Route::get('ajax/projects-filter', 'ajaxGetProjectsFilter')->name('ajax.projects-filter');
        });
    }
);

Theme::routes();
