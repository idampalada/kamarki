<?php

namespace Database\Seeders;

use Botble\Base\Models\MetaBox as MetaBoxModel;
use Botble\Base\Supports\BaseSeeder;
use Botble\Language\Models\LanguageMeta;
use Botble\Menu\Models\Menu as MenuModel;
use Botble\Menu\Models\MenuLocation;
use Botble\Menu\Models\MenuNode;
use Botble\Page\Models\Page;
use Botble\RealEstate\Models\Project;
use Botble\RealEstate\Models\Property;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Botble\Menu\Facades\Menu;

class MenuSeeder extends BaseSeeder
{
    public function run(): void
    {
        MenuModel::query()->truncate();
        MenuLocation::query()->truncate();
        MenuNode::query()->truncate();
        MetaBoxModel::query()->where('reference_type', MenuNode::class)->delete();
        LanguageMeta::query()->where('reference_type', MenuModel::class)->delete();
        LanguageMeta::query()->where('reference_type', MenuLocation::class)->delete();

        $data = [
            'en_US' => [
                [
                    'name' => 'Main menu',
                    'location' => 'main-menu',
                    'items' => [
                        [
                            'title' => 'Home',
                            'children' => [
                                [
                                    'title' => 'Home One',
                                    'reference_type' => Page::class,
                                    'reference_id' => 1,
                                ],
                                [
                                    'title' => 'Home Two',
                                    'reference_type' => Page::class,
                                    'reference_id' => 2,
                                ],
                                [
                                    'title' => 'Home Three',
                                    'reference_type' => Page::class,
                                    'reference_id' => 3,
                                ],
                                [
                                    'title' => 'Home Four',
                                    'reference_type' => Page::class,
                                    'reference_id' => 4,
                                ],
                            ],
                        ],
                        [
                            'title' => 'Projects',
                            'url' => '/projects',
                            'children' => [
                                [
                                    'title' => 'Projects List',
                                    'reference_type' => Page::class,
                                    'reference_id' => 5,
                                ],
                                [
                                    'title' => 'Project Detail',
                                    'url' => str_replace(url(''), '', Project::first()->url),
                                ],
                            ],
                        ],
                        [
                            'title' => 'Properties',
                            'reference_type' => Page::class,
                            'reference_id' => 6,
                            'children' => [
                                [
                                    'title' => 'Properties List',
                                    'reference_type' => Page::class,
                                    'reference_id' => 6,
                                ],
                                [
                                    'title' => 'Property Detail',
                                    'url' => str_replace(url(''), '', Property::first()->url),
                                ],
                            ],
                        ],
                        [
                            'title' => 'Page',
                            'url' => '/page',
                            'children' => [
                                [
                                    'title' => 'Agents',
                                    'url' => '/agents',
                                ],
                                [
                                    'title' => 'Wishlist',
                                    'reference_type' => Page::class,
                                    'reference_id' => 16,
                                ],
                                [
                                    'title' => 'About Us',
                                    'reference_type' => Page::class,
                                    'reference_id' => 7,
                                ],
                                [
                                    'title' => 'Features',
                                    'reference_type' => Page::class,
                                    'reference_id' => 8,
                                ],
                                [
                                    'title' => 'Pricing',
                                    'reference_type' => Page::class,
                                    'reference_id' => 9,
                                ],
                                [
                                    'title' => 'FAQs',
                                    'reference_type' => Page::class,
                                    'reference_id' => 10,
                                ],
                                [
                                    'title' => 'Contact',
                                    'reference_type' => Page::class,
                                    'reference_id' => 15,
                                ],
                                [
                                    'title' => 'Auth Pages',
                                    'url' => '/auth-pages',
                                    'children' => [
                                        [
                                            'title' => 'Login',
                                            'url' => '/login',
                                        ],
                                        [
                                            'title' => 'Signup',
                                            'url' => '/register',
                                        ],
                                        [
                                            'title' => 'Reset Password',
                                            'url' => '/password/request',
                                        ],
                                    ],
                                ],
                                [
                                    'title' => 'Utility',
                                    'url' => '/utility',
                                    'children' => [
                                        [
                                            'title' => 'Terms of Services',
                                            'reference_type' => Page::class,
                                            'reference_id' => 11,
                                        ],
                                        [
                                            'title' => 'Privacy Policy',
                                            'url' => '/privacy-policy',
                                            'reference_type' => Page::class,
                                            'reference_id' => 12,
                                        ],
                                    ],
                                ],
                                [
                                    'title' => 'Special',
                                    'url' => '/special',
                                    'children' => [
                                        [
                                            'title' => 'Coming soon',
                                            'reference_type' => Page::class,
                                            'reference_id' => 13,
                                        ],
                                        [
                                            'title' => '404 Error',
                                            'url' => '/404',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'Company',
                    'items' => [
                        [
                            'title' => 'About Us',
                            'reference_type' => Page::class,
                            'reference_id' => 7,
                        ],
                        [
                            'title' => 'Services',
                            'url' => '#',
                        ],
                        [
                            'title' => 'Pricing',
                            'reference_type' => Page::class,
                            'reference_id' => 9,
                        ],
                        [
                            'title' => 'News',
                            'reference_type' => Page::class,
                            'reference_id' => 14,
                        ],
                        [
                            'title' => 'Login',
                            'url' => url('login'),
                        ],
                    ],
                ],
                [
                    'name' => 'Useful Links',
                    'items' => [
                        [
                            'title' => 'Terms of Services',
                            'reference_type' => Page::class,
                            'reference_id' => 11,
                        ],
                        [
                            'title' => 'Privacy Policy',
                            'reference_type' => Page::class,
                            'reference_id' => 12,
                        ],
                        [
                            'title' => 'Listing',
                            'reference_type' => Page::class,
                            'reference_id' => 6,
                        ],
                        [
                            'title' => 'Contact',
                            'reference_type' => Page::class,
                            'reference_id' => 14,
                        ],
                    ],
                ],
            ],
            'vi' => [
                [
                    'name' => 'Menu chính',
                    'location' => 'main-menu',
                    'items' => [
                        [
                            'title' => 'Trang chủ',
                            'children' => [
                                [
                                    'title' => 'Trang chủ 1',
                                    'reference_type' => Page::class,
                                    'reference_id' => 1,
                                ],
                                [
                                    'title' => 'Trang chủ 2',
                                    'reference_type' => Page::class,
                                    'reference_id' => 2,
                                ],
                                [
                                    'title' => 'Trang chủ 3',
                                    'reference_type' => Page::class,
                                    'reference_id' => 3,
                                ],
                                [
                                    'title' => 'Trang chủ 4',
                                    'reference_type' => Page::class,
                                    'reference_id' => 4,
                                ],
                            ],
                        ],
                        [
                            'title' => 'Dự án',
                            'url' => '/projects',
                            'children' => [
                                [
                                    'title' => 'Danh sách dự án',
                                    'reference_type' => Page::class,
                                    'reference_id' => 5,
                                ],
                                [
                                    'title' => 'Chi tiết dự án',
                                    'url' => str_replace(url(''), '', Project::first()->url),
                                ],
                            ],
                        ],
                        [
                            'title' => 'Nhà - Căn hộ',
                            'reference_type' => Page::class,
                            'reference_id' => 6,
                            'children' => [
                                [
                                    'title' => 'Danh sách Nhà - Căn hộ',
                                    'reference_type' => Page::class,
                                    'reference_id' => 6,
                                ],
                                [
                                    'title' => 'Chi tiết Nhà - Căn hộ',
                                    'url' => str_replace(url(''), '', Property::first()->url),
                                ],
                            ],
                        ],
                        [
                            'title' => 'Trang',
                            'url' => '/page',
                            'children' => [
                                [
                                    'title' => 'Danh sách yêu thích',
                                    'reference_type' => Page::class,
                                    'reference_id' => 16,
                                ],
                                [
                                    'title' => 'Giới thiệu',
                                    'reference_type' => Page::class,
                                    'reference_id' => 7,
                                ],
                                [
                                    'title' => 'Tính năng',
                                    'reference_type' => Page::class,
                                    'reference_id' => 8,
                                ],
                                [
                                    'title' => 'Bảng giá',
                                    'reference_type' => Page::class,
                                    'reference_id' => 9,
                                ],
                                [
                                    'title' => 'FAQs',
                                    'reference_type' => Page::class,
                                    'reference_id' => 10,
                                ],
                                [
                                    'title' => 'Trang xác thực',
                                    'url' => '/auth-pages',
                                    'children' => [
                                        [
                                            'title' => 'Đăng nhập',
                                            'url' => '/login',
                                        ],
                                        [
                                            'title' => 'Đăng ký',
                                            'url' => '/register',
                                        ],
                                        [
                                            'title' => 'Khôi phục mật khẩu',
                                            'url' => '/password/request',
                                        ],
                                    ],
                                ],
                                [
                                    'title' => 'Hữu ích',
                                    'url' => '/utility',
                                    'children' => [
                                        [
                                            'title' => 'Điều khoản dịch vụ',
                                            'reference_type' => Page::class,
                                            'reference_id' => 11,
                                        ],
                                        [
                                            'title' => 'Chính sách bảo mật',
                                            'url' => '/privacy-policy',
                                            'reference_type' => Page::class,
                                            'reference_id' => 12,
                                        ],
                                    ],
                                ],
                                [
                                    'title' => 'Đặc biệt',
                                    'url' => '/special',
                                    'children' => [
                                        [
                                            'title' => 'Sắp có',
                                            'reference_type' => Page::class,
                                            'reference_id' => 13,
                                        ],
                                        [
                                            'title' => 'Trang lỗi 404',
                                            'url' => '/404',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        [
                            'title' => 'Liên hệ',
                            'reference_type' => Page::class,
                            'reference_id' => 15,
                        ],
                    ],
                ],
                [
                    'name' => 'Công ty',
                    'items' => [
                        [
                            'title' => 'Về chúng tôi',
                            'reference_type' => Page::class,
                            'reference_id' => 7,
                        ],
                        [
                            'title' => 'Dịch vụ',
                            'url' => '#',
                        ],
                        [
                            'title' => 'Bảng giá',
                            'reference_type' => Page::class,
                            'reference_id' => 9,
                        ],
                        [
                            'title' => 'Tin tức',
                            'reference_type' => Page::class,
                            'reference_id' => 13,
                        ],
                        [
                            'title' => 'Đăng nhập',
                            'url' => url('login'),
                        ],
                    ],
                ],
                [
                    'name' => 'Liên kết hữu ích',
                    'items' => [
                        [
                            'title' => 'Điều khoản dịch vụ',
                            'reference_type' => Page::class,
                            'reference_id' => 11,
                        ],
                        [
                            'title' => 'Chính sách bảo mật',
                            'reference_type' => Page::class,
                            'reference_id' => 12,
                        ],
                        [
                            'title' => 'Danh sách',
                            'reference_type' => Page::class,
                            'reference_id' => 6,
                        ],
                        [
                            'title' => 'Liên hệ',
                            'reference_type' => Page::class,
                            'reference_id' => 14,
                        ],
                    ],
                ],
            ],
        ];

        foreach ($data as $locale => $menus) {
            foreach ($menus as $index => $item) {
                $menu = MenuModel::query()->create(array_merge(Arr::except($item, ['items', 'location']), [
                    'slug' => $item['slug'] ?? Str::slug($item['name']),
                ]));

                if (isset($item['location'])) {
                    $menuLocation = MenuLocation::query()->create([
                        'menu_id' => $menu->id,
                        'location' => $item['location'],
                    ]);

                    $originValue = LanguageMeta::query()->where([
                        'reference_id' => $locale == 'en_US' ? 1 : 2,
                        'reference_type' => MenuLocation::class,
                    ])->value('lang_meta_origin');

                    LanguageMeta::saveMetaData($menuLocation, $locale, $originValue);
                }

                foreach ($item['items'] as $menuNode) {
                    $this->createMenuNode($index, $menuNode, $locale, $menu->id);
                }

                $originValue = null;

                if ($locale !== 'en_US') {
                    $originValue = LanguageMeta::query()->where([
                        'reference_id' => $index + 1,
                        'reference_type' => MenuModel::class,
                    ])->value('lang_meta_origin');
                }

                LanguageMeta::saveMetaData($menu, $locale, $originValue);
            }
        }

        Menu::clearCacheMenuItems();
    }

    protected function createMenuNode(int $index, array $menuNode, string $locale, int|string $menuId, int|string $parentId = 0): void
    {
        $menuNode['menu_id'] = $menuId;
        $menuNode['parent_id'] = $parentId;

        if (isset($menuNode['url'])) {
            $menuNode['url'] = str_replace(url(''), '', $menuNode['url']);
        }

        if (Arr::has($menuNode, 'children')) {
            $children = $menuNode['children'];
            $menuNode['has_child'] = true;

            unset($menuNode['children']);
        } else {
            $children = [];
            $menuNode['has_child'] = false;
        }

        $createdNode = MenuNode::query()->create($menuNode);

        if ($children) {
            foreach ($children as $child) {
                $this->createMenuNode($index, $child, $locale, $menuId, $createdNode->id);
            }
        }
    }
}
