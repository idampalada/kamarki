<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\RealEstate\Models\Account;
use Illuminate\Support\Str;
use Botble\Base\Facades\MetaBox;

class AccountSeeder extends BaseSeeder
{
    public function run(): void
    {
        Account::query()->truncate();

        $files = $this->uploadFiles('accounts');

        $companies = ['Google', 'Facebook', 'Tiki', 'Amazon', 'Microsoft', 'Accenture', 'Cognizant'];

        Account::query()->create([
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => 'agent@archielite.com',
            'username' => Str::slug(fake()->unique()->userName()),
            'password' => bcrypt('12345678'),
            'dob' => fake()->dateTime(),
            'phone' => fake()->e164PhoneNumber(),
            'description' => fake()->realText(),
            'credits' => 10,
            'confirmed_at' => now(),
            'avatar_id' => $files[fake()->numberBetween(0, 9)]['data']->id,
            'company' => fake()->randomElement($companies),
        ]);

        foreach (range(1, 20) as $i) {
            $account = Account::query()->create([
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'email' => fake()->email(),
                'username' => Str::slug(fake()->unique()->userName()),
                'password' => bcrypt(fake()->password()),
                'dob' => fake()->dateTime(),
                'phone' => fake()->e164PhoneNumber(),
                'description' => fake()->realText(),
                'credits' => fake()->numberBetween(1, 10),
                'confirmed_at' => now(),
                'avatar_id' => $files[fake()->numberBetween(0, 9)]['data']->id,
                'company' => fake()->randomElement($companies),
                'is_featured' => rand(0, 1),
            ]);

            MetaBox::saveMetaBoxData($account, 'social_facebook', 'facebook.com');
            MetaBox::saveMetaBoxData($account, 'social_instagram', 'instagram.com');
            MetaBox::saveMetaBoxData($account, 'social_linkedin', 'linkedin.com');
        }
    }
}
