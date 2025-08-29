<?php

namespace Database\Seeders;

use Botble\Base\Models\MetaBox;
use Botble\Base\Supports\BaseSeeder;
use Botble\Language\Models\LanguageMeta;
use Botble\Slug\Models\Slug;
use Botble\Testimonial\Models\Testimonial;
use Illuminate\Support\Facades\DB;

class TestimonialSeeder extends BaseSeeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Christa Smith',
                'company' => 'Manager',
            ],
            [
                'name' => 'John Smith',
                'company' => 'Product designer',
            ],
            [
                'name' => 'Sayen Ahmod',
                'company' => 'Developer',
            ],
            [
                'name' => 'Tayla Swef',
                'company' => 'Graphic designer',
            ],
            [
                'name' => 'Christa Smith',
                'company' => 'Graphic designer',
            ],
            [
                'name' => 'James Garden',
                'company' => 'Web Developer',
            ],
        ];

        Testimonial::query()->truncate();
        DB::table('testimonials_translations')->truncate();
        Slug::query()->where('reference_type', Testimonial::class)->delete();
        MetaBox::query()->where('reference_type', Testimonial::class)->delete();
        LanguageMeta::query()->where('reference_type', Testimonial::class)->delete();

        foreach ($testimonials as $key => $item) {
            Testimonial::query()->create(array_merge($item, [
                'image' => 'clients/0' . ($key + 1) . '.jpg',
                'content' => fake()->realText(),
            ]));
        }

        $translations = [
            [
                'name' => 'Adam Williams',
                'company' => 'Giám đốc Microsoft',
            ],
            [
                'name' => 'Retha Deowalim',
                'company' => 'Giám đốc Apple',
            ],
            [
                'name' => 'Sam J. Wasim',
                'company' => 'Nhà sáng lập Pio',
            ],
            [
                'name' => 'Usan Gulwarm',
                'company' => 'Giám đốc Facewarm',
            ],
        ];

        foreach ($translations as $key => $translation) {
            DB::table('testimonials_translations')->insert(array_merge($translation, [
                'lang_code' => 'vi',
                'content' => fake()->realText(),
                'testimonials_id' => $key + 1,
            ]));
        }
    }
}
