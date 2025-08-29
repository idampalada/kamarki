<?php

namespace Database\Seeders;

use Botble\RealEstate\Models\Account;
use Botble\RealEstate\Models\Project;
use Botble\RealEstate\Models\Property;
use Botble\RealEstate\Models\Review;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        Review::query()->truncate();

        $accountsCount = Account::query()->count();
        $projectsCount = Project::query()->count();
        $propertiesCount = Property::query()->count();

        $faker = fake();

        foreach (range(1, 200) as $i) {
            $reviewable = $faker->randomElement([
                ['id' => rand(1, $projectsCount), 'type' => Project::class],
                ['id' => rand(1, $propertiesCount), 'type' => Property::class],
            ]);

            Review::query()->insertOrIgnore([
                'account_id' => rand(1, $accountsCount),
                'reviewable_type' => $reviewable['type'],
                'reviewable_id' => $reviewable['id'],
                'content' => fake()->realText(rand(30, 300)),
                'star' => rand(1, 5),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
