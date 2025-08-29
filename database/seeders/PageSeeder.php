<?php

namespace Database\Seeders;

use Botble\Base\Models\MetaBox as MetaBoxModel;
use Botble\Base\Supports\BaseSeeder;
use Botble\Language\Models\LanguageMeta;
use Botble\Page\Models\Page;
use Botble\Slug\Models\Slug;
use Botble\Base\Facades\Html;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Botble\Base\Facades\MetaBox;
use Botble\Slug\Facades\SlugHelper;

class PageSeeder extends BaseSeeder
{
    public function run(): void
    {
        Page::query()->truncate();
        DB::table('pages_translations')->truncate();
        Slug::query()->where('reference_type', Page::class)->delete();
        MetaBoxModel::query()->where('reference_type', Page::class)->delete();
        LanguageMeta::query()->where('reference_type', Page::class)->delete();

        $pages = [
            [
                'name' => 'Home One',
                'content' =>
                    Html::tag('div', htmlentities('[hero-banner style="1" title="We will help you find <br> your Wonderful home" title_highlight="Wonderful" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." background_images="backgrounds/01.jpg,backgrounds/02.jpg,backgrounds/03.jpg,backgrounds/04.jpg" enabled_search_box="1" enabled_search_projects="1"][/hero-banner]')) .
                    Html::tag('div', '[intro-about-us title="Efficiency. Transparency. Control." description="Hously developed a platform for the Real Estate marketplace that allows buyers and sellers to easily execute a transaction on their own. The platform drives efficiency, cost transparency and control into the hands of the consumers. Hously is Real Estate Redefined." text_button_action="Learn More" url_button_action="#" image="general/about.jpg" youtube_video_url="https://www.youtube.com/watch?v=y9j-BL5ocW8"][/intro-about-us]') .
                    Html::tag('div', '[how-it-works title="How It Works" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." icon_1="mdi mdi-home-outline" title_1="Evaluate Property" description_1="If the distribution of letters and \'words\' is random, the reader will not be distracted from making." icon_2="mdi mdi-bag-personal-outline" title_2="Meeting with Agent" description_2="If the distribution of letters and \'words\' is random, the reader will not be distracted from making." icon_3="mdi mdi-key-outline" title_3="Close the Deal" description_3="If the distribution of letters and \'words\' is random, the reader will not be distracted from making."][/how-it-works]') .
                    Html::tag('div', '[properties-by-locations title="Find your inspiration with Hously" title_highlight_text="inspiration with" subtitle="Properties By Location and Country"][/properties-by-locations]') .
                    Html::tag('div', '[featured-projects title="Featured Projects" subtitle="We make the best choices with the hottest and most prestigious projects, please visit the details below to find out more." limit="6"][/featured-projects]') .
                    Html::tag('div', '[featured-properties title="Featured Properties" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." limit="6"][/featured-properties]') .
                    Html::tag('div', '[recently-viewed-properties title="Recently Viewed Properties" subtitle="Your currently viewed properties." limit="3"][/recently-viewed-properties]') .
                    Html::tag('div', '[testimonials title="What Our Client Say?" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." limit="6"][/testimonials]') .
                    Html::tag('div', '[featured-agents title="Featured Agents" subtitle="Below is the featured agent." limit="6"][/featured-agents]') .
                    Html::tag('div', '[featured-posts title="Latest News" subtitle="Below is the latest real estate news we get regularly updated from reliable sources." limit="3"][/featured-posts]') .
                    Html::tag('div', '[get-in-touch title="Have question? Get in touch!" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." button_label="Contact us" button_url="/contact"][/get-in-touch]')
                ,
                'template' => 'default',
                'metabox' => [
                    'navbar_style' => 'dark',
                ],
            ],
            [
                'name' => 'Home Two',
                'content' =>
                    Html::tag('div', htmlentities('[hero-banner style="2" title="Easy way to find your <br> dream property" title_highlight="Wonderful" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." background_images="backgrounds/01.jpg,backgrounds/02.jpg,backgrounds/03.jpg,backgrounds/04.jpg" enabled_search_box="1" enabled_search_projects="1"][/hero-banner]')) .
                    Html::tag('div', '[intro-about-us title="Efficiency. Transparency. Control." description="Hously developed a platform for the Real Estate marketplace that allows buyers and sellers to easily execute a transaction on their own. The platform drives efficiency, cost transparency and control into the hands of the consumers. Hously is Real Estate Redefined." text_button_action="Learn More" url_button_action="#" image="general/about.jpg" youtube_video_url="https://www.youtube.com/watch?v=y9j-BL5ocW8"][/intro-about-us]') .
                    Html::tag('div', '[how-it-works title="How It Works" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." icon_1="mdi mdi-home-outline" title_1="Evaluate Property" description_1="If the distribution of letters and \'words\' is random, the reader will not be distracted from making." icon_2="mdi mdi-bag-personal-outline" title_2="Meeting with Agent" description_2="If the distribution of letters and \'words\' is random, the reader will not be distracted from making." icon_3="mdi mdi-key-outline" title_3="Close the Deal" description_3="If the distribution of letters and \'words\' is random, the reader will not be distracted from making."][/how-it-works]') .
                    Html::tag('div', '[properties-by-locations title="Find your inspiration with Hously" title_highlight_text="inspiration with" subtitle="Properties By Location and Country"][/properties-by-locations]') .
                    Html::tag('div', '[featured-projects title="Featured Projects" subtitle="We make the best choices with the hottest and most prestigious projects, please visit the details below to find out more." limit="6"][/featured-projects]') .
                    Html::tag('div', '[featured-properties title="Featured Properties" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." limit="6"][/featured-properties]') .
                    Html::tag('div', '[recently-viewed-properties title="Recently Viewed Properties" subtitle="Your currently viewed properties." limit="3"][/recently-viewed-properties]') .
                    Html::tag('div', '[business-partners name_1="Amazon" url_1="https://www.amazon.com" logo_1="clients/amazon.png" name_2="Google" url_2="https://google.com" logo_2="clients/google.png" name_3="Lenovo" url_3="https://www.lenovo.com" logo_3="clients/lenovo.png" name_4="Paypal" url_4="https://paypal.com" logo_4="clients/paypal.png" name_5="Shopify" url_5="https://shopify.com" logo_5="clients/shopify.png" name_6="Spotify" url_6="https://spotify.com" logo_6="clients/spotify.png"][/business-partners]') .
                    Html::tag('div', '[testimonials title="What Our Client Say?" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." limit="6"][/testimonials]') .
                    Html::tag('div', '[featured-agents title="Featured Agents" subtitle="Below is the featured agent." limit="6"][/featured-agents]') .
                    Html::tag('div', '[featured-posts title="Latest News" subtitle="Below is the latest real estate news we get regularly updated from reliable sources." limit="3"][/featured-posts]') .
                    Html::tag('div', '[get-in-touch title="Have question? Get in touch!" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." button_label="Contact us" button_url="/contact"][/get-in-touch]')
                ,
                'template' => 'default',
                'metabox' => [
                    'navbar_style' => 'light',
                ],
            ],
            [
                'name' => 'Home Three',
                'content' =>
                    Html::tag('div', '[featured-properties-on-map][/featured-properties-on-map]') .
                    Html::tag('div', '[featured-properties title="Featured Properties" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." limit="9" style="list"][/featured-properties]') .
                    Html::tag('div', '[site-statistics title="Trusted by more than 10K users" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." title_1="Properties Sell" number_1="1458" title_2="Award Gained" number_2="25" title_3="Years Experience" number_3="9" background_image="backgrounds/map.png" style="has-title"][/site-statistics]') .
                    Html::tag('div', '[team title="Meet The Agent Team" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." weather="sunny" account_ids="3,5,6,10"][/team]') .
                    Html::tag('div', '[testimonials title="What Our Client Say?" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." limit="6" style="style-2"][/testimonials]') .
                    Html::tag('div', '[get-in-touch title="Have question? Get in touch!" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." button_label="Contact us" button_url="/contact"][/get-in-touch]'),
                'template' => 'default',
                'metabox' => [
                    'navbar_style' => 'dark',
                ],
            ],
            [
                'name' => 'Home Four',
                'content' =>
                Html::tag('div', '[hero-banner style="4" title="Find Your Perfect & Wonderful Home" title_highlight="Perfect & Wonderful" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." background_images="backgrounds/hero.jpg" youtube_video_url="https://youtu.be/yba7hPeTSjk" enabled_search_box="1" search_type="properties" enabled_search_projects="1"][/hero-banner]') .
                Html::tag('div', '[intro-about-us title="Efficiency. Transparency. Control." description="Hously developed a platform for the Real Estate marketplace that allows buyers and sellers to easily execute a transaction on their own. The platform drives efficiency, cost transparency and control into the hands of the consumers. Hously is Real Estate Redefined." text_button_action="Learn More" url_button_action="#" image="general/about.jpg" youtube_video_url="https://youtu.be/yba7hPeTSjk"][/intro-about-us]') .
                Html::tag('div', '[how-it-works title="How It Works" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." icon_1="mdi mdi-home-outline" title_1="Evaluate Property" description_1="If the distribution of letters and is random, the reader will not be distracted from making." icon_2="mdi mdi-bag-personal-outline" title_2="Meeting with Agent" description_2="If the distribution of letters and is random, the reader will not be distracted from making." icon_3="mdi mdi-key-outline" title_3="Close the Deal" description_3="If the distribution of letters and is random, the reader will not be distracted from making."][/how-it-works]') .
                Html::tag('div', '[featured-projects title="Featured Projects" subtitle="We make the best choices with the hottest and most prestigious projects, please visit the details below to find out more." limit="6"][/featured-projects]') .
                Html::tag('div', '[featured-properties limit="9"][/featured-properties]') .
                Html::tag('div', '[recently-viewed-properties title="Recently Viewed Properties" subtitle="Your currently viewed properties." limit="3"][/recently-viewed-properties]') .
                HtmL::tag('div', '[testimonials title="What Our Client Say?" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." limit="6"][/testimonials]') .
                Html::tag('div', '[featured-agents title="Featured Agents" subtitle="Below is the featured agent." limit="6"][/featured-agents]') .
                Html::tag('div', '[featured-posts title="Latest News" subtitle="Below is the latest real estate news we get regularly updated from reliable sources." limit="3"][/featured-posts]') .
                Html::tag('div', '[get-in-touch title="Have Question? Get in touch!" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." button_label="Contact us" button_url="#"][/get-in-touch]'),
                'template' => 'default',
                'metabox' => [
                    'navbar_style' => 'dark',
                ],
            ],
            [
                'name' => 'Projects',
                'content' =>
                    Html::tag('div', '[hero-banner style="default" title="Projects" subtitle="Each place is a good choice, it will help you make the right decision, do not miss the opportunity to discover our wonderful properties." background_images="backgrounds/01.jpg" enabled_search_box="1" search_type="projects"][/hero-banner]') .
                    Html::tag('div', '[projects-list number_of_projects_per_page="12"][/projects-list]')
                ,
                'template' => 'default',
                'metabox' => [
                    'navbar_style' => 'light',
                ],
            ],
            [
                'name' => 'Properties',
                'content' =>
                    Html::tag('div', '[hero-banner style="default" title="Properties" subtitle="Each place is a good choice, it will help you make the right decision, do not miss the opportunity to discover our wonderful properties." background_images="backgrounds/01.jpg" enabled_search_box="1" search_type="properties"][/hero-banner]') .
                    Html::tag('div', '[properties-list number_of_properties_per_page="12"][/properties-list]')
                ,
                'template' => 'default',
                'metabox' => [
                    'navbar_style' => 'light',
                ],
            ],
            [
                'name' => 'About Us',
                'description' => fake()->text(),
                'content' =>
                    Html::tag('div', '[intro-about-us title="Efficiency. Transparency. Control." description="Hously developed a platform for the Real Estate marketplace that allows buyers and sellers to easily execute a transaction on their own. The platform drives efficiency, cost transparency and control into the hands of the consumers. Hously is Real Estate Redefined." text_button_action="Learn More" url_button_action="#" image="general/about.jpg" youtube_video_url="https://www.youtube.com/watch?v=y9j-BL5ocW8"][/intro-about-us]') .
                    Html::tag('div', '[how-it-works title="How It Works" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." icon_1="mdi mdi-home-outline" title_1="Evaluate Property" description_1="If the distribution of letters and is random, the reader will not be distracted from making." icon_2="mdi mdi-bag-personal-outline" title_2="Meeting with Agent" description_2="If the distribution of letters and  is random, the reader will not be distracted from making." icon_3="mdi mdi-key-outline" title_3="Close the Deal" description_3="If the distribution of letters and  is random, the reader will not be distracted from making."][/how-it-works]') .
                    Html::tag('div', '[site-statistics title_1="Properties Sell" number_1="1548" title_2="Award Gained" number_2="25" title_3="Years Experience" number_3="9" style="no-title"][/site-statistics]') .
                    Html::tag('div', '[team title="Meet The Agent Team" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." weather="sunny" account_ids="3,5,6,10"][/team]') .
                    Html::tag('div', '[testimonials title="What Our Client Say?" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." limit="6" style="style-2"][/testimonials]') .
                    Html::tag('div', '[get-in-touch title="Have question? Get in touch!" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." button_label="Contact us" button_url="/contact"][/get-in-touch]'),
                'template' => 'hero',
                'metabox' => [
                    'navbar_style' => 'light',
                ],
            ],
            [
                'name' => 'Features',
                'content' =>
                    Html::tag('div', '[feature-block icon_1="mdi mdi-cards-heart" title_1="Comfortable" url_1="#" description_1="If the distribution of letters and  is random, the reader will not be distracted from making." icon_2="mdi mdi-shield-sun" title_2="Extra Security" url_2="#" description_2="If the distribution of letters and  is random, the reader will not be distracted from making." icon_3="mdi mdi-star" title_3="Luxury" url_3="#" description_3="If the distribution of letters and  is random, the reader will not be distracted from making." icon_4="mdi mdi-currency-usd" title_4="Best Price" url_4="#" description_4="If the distribution of letters and  is random, the reader will not be distracted from making." icon_5="mdi mdi-map-marker" title_5="Strategic Location" url_5="#" description_5="If the distribution of letters and  is random, the reader will not be distracted from making." icon_6="mdi mdi-chart-arc" title_6="Efficient" url_6="#" description_6="If the distribution of letters and  is random, the reader will not be distracted from making."][/feature-block]') .
                    Html::tag('div', '[testimonials title="What Our Client Say?" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." limit="6"][/testimonials]') .
                    Html::tag('div', '[get-in-touch title="Have question? Get in touch!" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." button_label="Contact us" button_url="/contact"][/get-in-touch]')
                ,
                'template' => 'hero',
                'metabox' => [
                    'navbar_style' => 'light',
                ],
            ],
            [
                'name' => 'Pricing Plans',
                'content' =>
                    Html::tag('div', '[pricing][/pricing]') .
                    Html::tag('div', '[get-in-touch title="Have question? Get in touch!" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." button_label="Contact us" button_url="/contact"][/get-in-touch]')
                ,
                'template' => 'hero',
                'metabox' => [
                    'navbar_style' => 'light',
                ],
            ],
            [
                'name' => 'Frequently Asked Questions',
                'content' =>
                    Html::tag('div', '[faq][/faq]') .
                    Html::tag('div', '[get-in-touch title="Have question? Get in touch!" subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." button_label="Contact" button_url="/contact"][/get-in-touch]')
                ,
                'template' => 'hero',
                'metabox' => [
                    'navbar_style' => 'light',
                ],
            ],
            [
                'name' => 'Terms of Services',
                'content' => File::get(database_path('seeders/contents/article-content.html')),
                'template' => 'article',
            ],
            [
                'name' => 'Privacy Policy',
                'content' => File::get(database_path('seeders/contents/article-content.html')),
                'template' => 'article',
            ],
            [
                'name' => 'Coming soon',
                'content' => Html::tag('div', '[coming-soon title="We Are Coming Soon..." subtitle="A great platform to buy, sell and rent your properties without any agent or commissions." time="2023-07-05" enable_snow_effect="0,1"][/coming-soon]'),
                'template' => 'empty',
            ],
            [
                'name' => 'News',
                'template' => 'hero',
            ],
            [
                'name' => 'Contact',
                'content' =>
                    Html::tag('div', '[google-map address="24 Roberts Street, SA73, Chester"][/google-map]') .
                    Html::tag('div', '[contact-form title="Get in touch!"][/contact-form]') .
                    Html::tag('div', '[contact-info phone="+152 534-468-854" phone_description="The phrasal sequence of the is now so that many campaign and benefit" email="contact@example.com" email_description="The phrasal sequence of the is now so that many campaign and benefit" address="C/54 Northwest Freeway, Suite 558, Houston, USA 485" address_description="C/54 Northwest Freeway, Suite 558, Houston, USA 485"][/contact-info]')
                ,
                'template' => 'default',
            ],
            [
                'name' => 'Wishlist',
                'content' =>
                    Html::tag('div', '[favorite-projects title="My Favorite Projects"][/favorite-projects]') .
                    Html::tag('div', '[favorite-properties title="My Favorite Projects"][/favorite-properties]')
                ,
                'template' => 'hero',
                'metabox' => [
                    'navbar_style' => 'light',
                ],
            ],
        ];

        foreach ($pages as $item) {
            $page = Page::query()->create([
                'user_id' => 1,
                'name' => Arr::get($item, 'name'),
                'description' => Arr::get($item, 'description'),
                'content' => Arr::get($item, 'content'),
                'template' => Arr::get($item, 'template', 'default'),
            ]);

            Slug::query()->create([
                'reference_type' => Page::class,
                'reference_id' => $page->id,
                'key' => Str::slug($page->name),
                'prefix' => SlugHelper::getPrefix(Page::class),
            ]);

            foreach (Arr::get($item, 'metabox', []) as $key => $value) {
                MetaBox::saveMetaBoxData($page, $key, $value);
            }
        }

        $translations = [];

        foreach ($translations as $key => $item) {
            DB::table('pages_translations')->insert(array_merge($item, [
                'lang_code' => 'vi',
                'pages_id' => $key + 1,
            ]));
        }
    }
}
