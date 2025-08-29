<?php

namespace Database\Seeders;

use Botble\Base\Models\MetaBox as MetaBoxModel;
use Botble\Base\Supports\BaseSeeder;
use Botble\Language\Models\LanguageMeta;
use Botble\Location\Models\City;
use Botble\Location\Models\Country;
use Botble\Location\Models\State;
use Botble\Slug\Models\Slug;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Botble\Base\Facades\MetaBox;

class LocationSeeder extends BaseSeeder
{
    public function run(): void
    {
        Country::query()->truncate();
        State::query()->truncate();
        City::query()->truncate();

        DB::table('countries_translations')->truncate();
        DB::table('states_translations')->truncate();
        DB::table('cities_translations')->truncate();

        Slug::query()->whereIn('reference_type', [City::class, State::class, Country::class])->delete();
        MetaBoxModel::query()->whereIn('reference_type', [City::class, State::class, Country::class])->delete();
        LanguageMeta::query()->whereIn('reference_type', [City::class, State::class, Country::class])->delete();

        $this->uploadFiles('cities');

        $countries = [
            [
                'name' => 'France',
                'nationality' => 'French',
                'code' => 'FRA',
            ],
            [
                'name' => 'England',
                'nationality' => 'English',
                'code' => 'UK',
            ],
            [
                'name' => 'USA',
                'nationality' => 'Americans',
                'code' => 'US',
            ],
            [
                'name' => 'Holland',
                'nationality' => 'Dutch',
                'code' => 'HL',
            ],
            [
                'name' => 'Denmark',
                'nationality' => 'Danish',
                'code' => 'DN',
            ],
            [
                'name' => 'Germany',
                'nationality' => 'Danish',
                'code' => 'DN',
            ],
        ];

        $states = [
            [
                'name' => 'France',
                'abbreviation' => 'FR',
                'country_id' => 1,
            ],
            [
                'name' => 'England',
                'abbreviation' => 'EN',
                'country_id' => 2,
            ],
            [
                'name' => 'New York',
                'abbreviation' => 'NY',
                'country_id' => 1,
            ],
            [
                'name' => 'Holland',
                'abbreviation' => 'HL',
                'country_id' => 4,
            ],
            [
                'name' => 'Denmark',
                'abbreviation' => 'DN',
                'country_id' => 5,
            ],
            [
                'name' => 'Germany',
                'abbreviation' => 'GER',
                'country_id' => 1,
            ],
        ];

        $cities = [
            [
                'name' => 'Paris',
                'state_id' => 1,
                'country_id' => 1,
                'image' => 'cities/location-1.jpg',
                'is_featured' => true,
            ],
            [
                'name' => 'London',
                'state_id' => 2,
                'country_id' => 2,
                'image' => 'cities/location-2.jpg',
                'is_featured' => true,
            ],
            [
                'name' => 'New York',
                'state_id' => 3,
                'country_id' => 3,
                'image' => 'cities/location-3.jpg',
                'is_featured' => true,
            ],
            [
                'name' => 'Copenhagen',
                'state_id' => 4,
                'country_id' => 4,
                'image' => 'cities/location-4.jpg',
                'is_featured' => true,
            ],
            [
                'name' => 'Berlin',
                'state_id' => 5,
                'country_id' => 5,
                'image' => 'cities/location-5.jpg',
                'is_featured' => true,
            ],
        ];

        foreach ($countries as $country) {
            Country::query()->create($country);
        }

        foreach ($states as $state) {
            State::query()->create($state);
        }

        foreach ($cities as $key => $city) {
            $key++;
            $city['slug'] = Str::slug($city['name']);

            $result = City::query()->create($city);
            MetaBox::saveMetaBoxData($result, 'city_image', "locations/$key.jpg");
        }
    }
}
