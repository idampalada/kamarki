<?php

namespace Database\Seeders;

use Botble\ACL\Models\User;
use Botble\Base\Models\MetaBox as MetaBoxModel;
use Botble\Base\Supports\BaseSeeder;
use Botble\Blog\Models\Category;
use Botble\Blog\Models\Post;
use Botble\Blog\Models\Tag;
use Botble\Language\Models\LanguageMeta;
use Botble\Slug\Models\Slug;
use Botble\Base\Facades\Html;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Botble\Media\Facades\RvMedia;
use Botble\Slug\Facades\SlugHelper;

class BlogSeeder extends BaseSeeder
{
    public function run(): void
    {
        Post::query()->truncate();
        Category::query()->truncate();
        Tag::query()->truncate();

        DB::table('posts_translations')->truncate();
        DB::table('categories_translations')->truncate();
        DB::table('tags_translations')->truncate();

        Slug::query()->where('reference_type', Post::class)->delete();
        Slug::query()->where('reference_type', Tag::class)->delete();
        Slug::query()->where('reference_type', Category::class)->delete();
        MetaBoxModel::query()->where('reference_type', Post::class)->delete();
        MetaBoxModel::query()->where('reference_type', Tag::class)->delete();
        MetaBoxModel::query()->where('reference_type', Category::class)->delete();
        LanguageMeta::query()->where('reference_type', Post::class)->delete();
        LanguageMeta::query()->where('reference_type', Tag::class)->delete();
        LanguageMeta::query()->where('reference_type', Category::class)->delete();

        $usersCount = User::query()->count();

        $categories = [
            'Design',
            'Lifestyle',
            'Travel Tips',
            'Healthy',
            'Travel Tips',
            'Hotel',
            'Nature',
        ];

        foreach ($categories as $item) {
            $category = Category::query()->create([
                'name' => $item,
                'description' => fake()->realText(),
                'author_type' => User::class,
                'author_id' => rand(1, $usersCount),
                'is_featured' => rand(0, 1),
            ]);

            Slug::query()->create([
                'reference_type' => Category::class,
                'reference_id' => $category->id,
                'key' => Str::slug($category->name),
                'prefix' => SlugHelper::getPrefix(Category::class),
            ]);
        }

        $tags = [
            'New',
            'Event',
            'Villa',
            'Apartment',
            'Condo',
            'Luxury villa',
            'Family home',
        ];

        foreach ($tags as $item) {
            $tag = Tag::query()->create([
                'name' => $item,
                'author_type' => User::class,
                'author_id' => rand(1, $usersCount),
            ]);

            Slug::query()->create([
                'reference_type' => Tag::class,
                'reference_id' => $tag->id,
                'key' => Str::slug($tag->name),
                'prefix' => SlugHelper::getPrefix(Tag::class),
            ]);
        }

        $posts = [
            'The Top 2020 Handbag Trends to Know',
            'Top Search Engine Optimization Strategies!',
            'Which Company Would You Choose?',
            'Used Car Dealer Sales Tricks Exposed',
            '20 Ways To Sell Your Product Faster',
            'The Secrets Of Rich And Famous Writers',
            'Imagine Losing 20 Pounds In 14 Days!',
            'Are You Still Using That Slow, Old Typewriter?',
            'A Skin Cream That’s Proven To Work',
            '10 Reasons To Start Your Own, Profitable Website!',
            'Simple Ways To Reduce Your Unwanted Wrinkles!',
            'Apple iMac with Retina 5K display review',
            '10,000 Web Site Visitors In One Month:Guaranteed',
            'Unlock The Secrets Of Selling High Ticket Items',
            '4 Expert Tips On How To Choose The Right Men’s Wallet',
            'Sexy Clutches: How to Buy & Wear a Designer Clutch Bag',
        ];

        $categoriesCount = Category::query()->count();
        $tagsCount = Tag::query()->count();

        foreach ($posts as $index => $item) {
            $content =
                ($index % 3 == 0 ? Html::tag(
                    'p',
                    '[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]'
                ) : '') .
                Html::tag('p', fake()->realText(1000)) .
                Html::tag(
                    'p',
                    Html::image(RvMedia::getImageUrl('news/' . fake()->numberBetween(1, 5) . '.jpg'))
                        ->toHtml(),
                    ['class' => 'text-center']
                ) .
                Html::tag('p', fake()->realText(500)) .
                Html::tag(
                    'p',
                    Html::image(RvMedia::getImageUrl('news/' . fake()->numberBetween(6, 10) . '.jpg'))
                        ->toHtml(),
                    ['class' => 'text-center']
                ) .
                Html::tag('p', fake()->realText(1000)) .
                Html::tag(
                    'p',
                    Html::image(RvMedia::getImageUrl('news/' . fake()->numberBetween(11, 14) . '.jpg'))
                        ->toHtml(),
                    ['class' => 'text-center']
                ) .
                Html::tag('p', fake()->realText(1000));

            $post = Post::query()->create([
                'author_type' => User::class,
                'author_id' => rand(1, $usersCount),
                'name' => $item,
                'views' => rand(100, 10000),
                'is_featured' => rand(0, 1),
                'image' => 'news/' . ($index + 1) . '.jpg',
                'description' => fake()->realText(),
                'content' => str_replace(url(''), '', $content),
            ]);

            $post->categories()->sync(fake()->randomElements(range(1, $categoriesCount), rand(1, 3)));

            $post->tags()->sync(fake()->randomElements(range(1, $tagsCount), rand(1, 3)));

            Slug::query()->create([
                'reference_type' => Post::class,
                'reference_id' => $post->id,
                'key' => Str::slug($post->name),
                'prefix' => SlugHelper::getPrefix(Post::class),
            ]);
        }

        $translations = [
            'Xu hướng túi xách hàng đầu năm 2020 cần biết',
            'Các Chiến lược Tối ưu hóa Công cụ Tìm kiếm Hàng đầu!',
            'Bạn sẽ chọn công ty nào?',
            'Lộ ra các thủ đoạn bán hàng của đại lý ô tô đã qua sử dụng',
            '20 Cách Bán Sản phẩm Nhanh hơn',
            'Bí mật của những nhà văn giàu có và nổi tiếng',
            'Hãy tưởng tượng bạn giảm 20 bảng Anh trong 14 ngày!',
            'Bạn vẫn đang sử dụng máy đánh chữ cũ, chậm đó?',
            'Một loại kem dưỡng da đã được chứng minh hiệu quả',
            '10 Lý do Để Bắt đầu Trang web Có Lợi nhuận của Riêng Bạn!',
            'Những cách đơn giản để giảm nếp nhăn không mong muốn của bạn!',
            'Đánh giá Apple iMac với màn hình Retina 5K',
            '10.000 Khách truy cập Trang Web Trong Một Tháng: Được Đảm bảo',
            'Mở khóa Bí mật Bán được vé Cao',
            '4 Lời khuyên của Chuyên gia về Cách Chọn Ví Nam Phù hợp',
            'Sexy Clutches: Cách Mua & Đeo Túi Clutch Thiết kế',
        ];

        foreach ($translations as $index => $item) {
            DB::table('posts_translations')->insert([
                'name' => $item,
                'lang_code' => 'vi',
                'posts_id' => $index + 1,
                'description' => fake('vi-VN')->realText(),
                'content' => fake('vi-VN')->realText(2000),
            ]);
        }
    }
}
