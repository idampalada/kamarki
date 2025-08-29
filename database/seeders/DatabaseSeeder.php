<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;

class DatabaseSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->activateAllPlugins();

        $this->call([
            LanguageSeeder::class,
            CurrencySeeder::class,
            CategorySeeder::class,
            UserSeeder::class,
            SettingSeeder::class,
            PageSeeder::class,
            LocationSeeder::class,
            BlogSeeder::class,
            TestimonialSeeder::class,
            WidgetSeeder::class,
            FaqSeeder::class,
            AccountSeeder::class,
            PackageSeeder::class,
            FacilitySeeder::class,
            InvestorSeeder::class,
            FeatureSeeder::class,
            ProjectSeeder::class,
            PropertySeeder::class,
            ReviewSeeder::class,
            ThemeOptionSeeder::class,
            MenuSeeder::class,
        ]);

        $this->uploadFiles('backgrounds');
        $this->uploadFiles('clients');
        $this->uploadFiles('general');
        $this->uploadFiles('properties');
        $this->uploadFiles('news');

        $this->finished();
    }
}
