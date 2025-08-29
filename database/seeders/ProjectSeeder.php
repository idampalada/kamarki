<?php

namespace Database\Seeders;

use Botble\ACL\Models\User;
use Botble\Base\Supports\BaseSeeder;
use Botble\Location\Models\City;
use Botble\Location\Models\Country;
use Botble\Location\Models\State;
use Botble\RealEstate\Enums\ProjectStatusEnum;
use Botble\RealEstate\Models\Category;
use Botble\RealEstate\Models\Investor;
use Botble\RealEstate\Models\Project;
use Botble\Slug\Models\Slug;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Botble\Slug\Facades\SlugHelper;

class ProjectSeeder extends BaseSeeder
{
    public function run(): void
    {
        Project::query()->truncate();
        DB::table('re_project_categories')->truncate();
        Slug::query()->where('reference_type', Project::class)->delete();

        $usersCount = User::query()->count();
        $categoriesCount = Category::query()->count();
        $investorsCount = Investor::query()->count();
        $countriesCount = Country::query()->count();
        $statesCount = State::query()->count();
        $citiesCount = City::query()->count();

        $projects = [
            'Walnut Park Apartments',
            'Sunshine Wonder Villas',
            'Diamond Island',
            'The Nassim',
            'Vinhomes Grand Park',
            'The Metropole Thu Thiem',
            'Villa on Grand Avenue',
            'Traditional Food Restaurant',
            'Villa on Hollywood Boulevard',
            'Office Space at Northwest 107th',
            'Home in Merrick Way',
            'Adarsh Greens',
            'Rustomjee Evershine Global City',
            'Godrej Exquisite',
            'Godrej Prime',
            'PS Panache',
            'Upturn Atmiya Centria',
            'Brigade Oasis',
        ];

        $faker = fake();

        foreach ($projects as $project) {
            $images = [];

            foreach ($faker->randomElements(range(1, 12), rand(5, 12)) as $image) {
                $images[] = "properties/$image.jpg";
            }

            $price = rand(100, 10000);

            $project = Project::query()->create([
                'name' => $project,
                'description' => File::get(database_path('/seeders/contents/property-description.html')),
                'content' => File::get(database_path('/seeders/contents/property-content.html')),
                'images' => $images,
                'location' => $faker->address(),
                'investor_id' => rand(1, $investorsCount),
                'number_block' => rand(1, 10),
                'number_floor' => rand(1, 50),
                'number_flat' => rand(10, 5000),
                'is_featured' => rand(0, 1),
                'date_finish' => $faker->dateTime(),
                'date_sell' => $faker->dateTime(),
                'latitude' => $faker->latitude(42.4772, 44.0153),
                'longitude' => $faker->longitude(-74.7624, -76.7517),
                'country_id' => rand(1, $countriesCount),
                'state_id' => rand(1, $statesCount),
                'city_id' => rand(1, $citiesCount),
                'status' => ProjectStatusEnum::SELLING,
                'price_from' => $price,
                'price_to' => $price + rand(500, 10000),
                'views' => rand(100, 10000),
                'currency_id' => 1,
                'author_id' => rand(1, $usersCount),
                'author_type' => User::class,
            ]);

            $project->categories()->attach($faker->randomElements(range(1, $categoriesCount), rand(1, 5)));

            Slug::query()->create([
                'reference_type' => Project::class,
                'reference_id' => $project->id,
                'key' => Str::slug($project->name),
                'prefix' => SlugHelper::getPrefix(Project::class),
            ]);
        }
    }
}
