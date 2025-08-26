<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Main Categories
        $categories = [
            [
                'name' => [
                    'ar' => 'آلات التصنيع',
                    'en' => 'Manufacturing Machines'
                ],
                'slug' => 'manufacturing-machines',
                'description' => [
                    'ar' => 'آلات التصنيع الحديثة والمتطورة',
                    'en' => 'Modern and advanced manufacturing machines'
                ],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 1,
                'meta_title' => [
                    'ar' => 'آلات التصنيع - Revira Industrial',
                    'en' => 'Manufacturing Machines - Revira Industrial'
                ],
                'meta_description' => [
                    'ar' => 'آلات التصنيع الحديثة والمتطورة لجميع الصناعات',
                    'en' => 'Modern and advanced manufacturing machines for all industries'
                ]
            ],
            [
                'name' => [
                    'ar' => 'معدات النقل',
                    'en' => 'Transportation Equipment'
                ],
                'slug' => 'transportation-equipment',
                'description' => [
                    'ar' => 'معدات النقل والرفع الصناعية',
                    'en' => 'Industrial transportation and lifting equipment'
                ],
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
                'meta_title' => [
                    'ar' => 'معدات النقل - Revira Industrial',
                    'en' => 'Transportation Equipment - Revira Industrial'
                ],
                'meta_description' => [
                    'ar' => 'معدات النقل والرفع الصناعية عالية الجودة',
                    'en' => 'High-quality industrial transportation and lifting equipment'
                ]
            ],
            [
                'name' => [
                    'ar' => 'أدوات القياس',
                    'en' => 'Measuring Tools'
                ],
                'slug' => 'measuring-tools',
                'description' => [
                    'ar' => 'أدوات القياس والفحص الدقيقة',
                    'en' => 'Precise measuring and inspection tools'
                ],
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 3,
                'meta_title' => [
                    'ar' => 'أدوات القياس - Revira Industrial',
                    'en' => 'Measuring Tools - Revira Industrial'
                ],
                'meta_description' => [
                    'ar' => 'أدوات القياس والفحص الدقيقة للصناعات',
                    'en' => 'Precise measuring and inspection tools for industries'
                ]
            ],
            [
                'name' => [
                    'ar' => 'معدات السلامة',
                    'en' => 'Safety Equipment'
                ],
                'slug' => 'safety-equipment',
                'description' => [
                    'ar' => 'معدات السلامة والحماية الصناعية',
                    'en' => 'Industrial safety and protection equipment'
                ],
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 4,
                'meta_title' => [
                    'ar' => 'معدات السلامة - Revira Industrial',
                    'en' => 'Safety Equipment - Revira Industrial'
                ],
                'meta_description' => [
                    'ar' => 'معدات السلامة والحماية الصناعية عالية الجودة',
                    'en' => 'High-quality industrial safety and protection equipment'
                ]
            ],
            [
                'name' => [
                    'ar' => 'قطع الغيار',
                    'en' => 'Spare Parts'
                ],
                'slug' => 'spare-parts',
                'description' => [
                    'ar' => 'قطع الغيار الأصلية للآلات والمعدات',
                    'en' => 'Original spare parts for machines and equipment'
                ],
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 5,
                'meta_title' => [
                    'ar' => 'قطع الغيار - Revira Industrial',
                    'en' => 'Spare Parts - Revira Industrial'
                ],
                'meta_description' => [
                    'ar' => 'قطع الغيار الأصلية للآلات والمعدات الصناعية',
                    'en' => 'Original spare parts for industrial machines and equipment'
                ]
            ]
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // Sub Categories
        $subCategories = [
            [
                'name' => [
                    'ar' => 'آلات CNC',
                    'en' => 'CNC Machines'
                ],
                'slug' => 'cnc-machines',
                'description' => [
                    'ar' => 'آلات التحكم الرقمي بالكمبيوتر',
                    'en' => 'Computer Numerical Control machines'
                ],
                'parent_id' => 1, // Manufacturing Machines
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 1
            ],
            [
                'name' => [
                    'ar' => 'آلات اللحام',
                    'en' => 'Welding Machines'
                ],
                'slug' => 'welding-machines',
                'description' => [
                    'ar' => 'آلات اللحام المتطورة',
                    'en' => 'Advanced welding machines'
                ],
                'parent_id' => 1, // Manufacturing Machines
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 2
            ],
            [
                'name' => [
                    'ar' => 'الرافعات الصناعية',
                    'en' => 'Industrial Cranes'
                ],
                'slug' => 'industrial-cranes',
                'description' => [
                    'ar' => 'رافعات صناعية عالية الكفاءة',
                    'en' => 'High-efficiency industrial cranes'
                ],
                'parent_id' => 2, // Transportation Equipment
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 1
            ],
            [
                'name' => [
                    'ar' => 'الرافعات الشوكية',
                    'en' => 'Forklifts'
                ],
                'slug' => 'forklifts',
                'description' => [
                    'ar' => 'رافعات شوكية للاستخدام الصناعي',
                    'en' => 'Industrial forklifts'
                ],
                'parent_id' => 2, // Transportation Equipment
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 2
            ]
        ];

        foreach ($subCategories as $subCategoryData) {
            Category::create($subCategoryData);
        }
    }
} 