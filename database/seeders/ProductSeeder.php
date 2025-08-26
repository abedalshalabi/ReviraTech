<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => [
                    'ar' => 'آلة CNC للخراطة',
                    'en' => 'CNC Lathe Machine'
                ],
                'slug' => 'cnc-lathe-machine',
                'short_description' => [
                    'ar' => 'آلة خراطة CNC عالية الدقة للتصنيع الصناعي',
                    'en' => 'High-precision CNC lathe machine for industrial manufacturing'
                ],
                'description' => [
                    'ar' => 'آلة خراطة CNC متطورة مصممة للتصنيع الصناعي عالي الدقة. تتميز بتحكم رقمي متقدم ونظام تبريد فعال.',
                    'en' => 'Advanced CNC lathe machine designed for high-precision industrial manufacturing. Features advanced digital control and efficient cooling system.'
                ],
                'price' => 150000,
                'sale_price' => 135000,
                'sku' => 'CNC-LATHE-001',
                'model' => 'TL-1500',
                'brand' => 'Revira',
                'country_of_origin' => 'ألمانيا',
                'category_id' => 6, // CNC Machines
                'technical_specifications' => [
                    'الطول الأقصى للعمل' => '1500mm',
                    'قطر العمل الأقصى' => '500mm',
                    'سرعة الدوران' => '2000 RPM',
                    'الطاقة الكهربائية' => '15kW',
                    'الوزن' => '2500kg'
                ],
                'features' => [
                    'تحكم رقمي متقدم',
                    'نظام تبريد فعال',
                    'دقة عالية في التصنيع',
                    'واجهة مستخدم سهلة',
                    'صيانة منخفضة'
                ],
                'applications' => [
                    'تصنيع الأجزاء الدقيقة',
                    'صناعة السيارات',
                    'صناعة الطيران',
                    'صناعة الأجهزة الطبية'
                ],
                'warranty' => 'ضمان شامل لمدة 3 سنوات',
                'is_active' => true,
                'is_featured' => true,
                'is_new' => true,
                'is_bestseller' => true,
                'sort_order' => 1,
                'image' => '/images/products/cnc-machine.svg',
                'meta_title' => [
                    'ar' => 'آلة CNC للخراطة - Revira Industrial',
                    'en' => 'CNC Lathe Machine - Revira Industrial'
                ],
                'meta_description' => [
                    'ar' => 'آلة خراطة CNC عالية الدقة للتصنيع الصناعي',
                    'en' => 'High-precision CNC lathe machine for industrial manufacturing'
                ]
            ],
            [
                'name' => [
                    'ar' => 'آلة لحام TIG',
                    'en' => 'TIG Welding Machine'
                ],
                'slug' => 'tig-welding-machine',
                'short_description' => [
                    'ar' => 'آلة لحام TIG متطورة للعمل على المعادن المختلفة',
                    'en' => 'Advanced TIG welding machine for various metals'
                ],
                'description' => [
                    'ar' => 'آلة لحام TIG متطورة مصممة للعمل على المعادن المختلفة مثل الألمنيوم والفولاذ المقاوم للصدأ.',
                    'en' => 'Advanced TIG welding machine designed for various metals including aluminum and stainless steel.'
                ],
                'price' => 25000,
                'sku' => 'TIG-WELD-001',
                'model' => 'TW-200',
                'brand' => 'Revira',
                'country_of_origin' => 'اليابان',
                'category_id' => 7, // Welding Machines
                'technical_specifications' => [
                    'الطاقة القصوى' => '200A',
                    'الجهد الكهربائي' => '220V/380V',
                    'عامل العمل' => '60%',
                    'الوزن' => '45kg',
                    'الأبعاد' => '600x400x300mm'
                ],
                'features' => [
                    'تحكم رقمي دقيق',
                    'حماية من الحرارة الزائدة',
                    'وضع النبض المتقدم',
                    'سهولة الاستخدام',
                    'صيانة منخفضة'
                ],
                'applications' => [
                    'لحام الألمنيوم',
                    'لحام الفولاذ المقاوم للصدأ',
                    'صناعة السيارات',
                    'صناعة الطيران'
                ],
                'warranty' => 'ضمان شامل لمدة 2 سنوات',
                'is_active' => true,
                'is_featured' => false,
                'is_new' => true,
                'is_bestseller' => false,
                'sort_order' => 2,
                'image' => '/images/products/welding-machine.svg'
            ],
            [
                'name' => [
                    'ar' => 'رافعة جسرية',
                    'en' => 'Overhead Crane'
                ],
                'slug' => 'overhead-crane',
                'short_description' => [
                    'ar' => 'رافعة جسرية صناعية عالية الكفاءة',
                    'en' => 'High-efficiency industrial overhead crane'
                ],
                'description' => [
                    'ar' => 'رافعة جسرية صناعية عالية الكفاءة مصممة للعمل في المصانع والمستودعات.',
                    'en' => 'High-efficiency industrial overhead crane designed for factories and warehouses.'
                ],
                'price' => 500000,
                'sku' => 'CRANE-OH-001',
                'model' => 'OC-10T',
                'brand' => 'Revira',
                'country_of_origin' => 'ألمانيا',
                'category_id' => 8, // Industrial Cranes
                'technical_specifications' => [
                    'الحمولة القصوى' => '10 طن',
                    'المدى' => '20 متر',
                    'ارتفاع الرفع' => '15 متر',
                    'سرعة الرفع' => '8 م/دقيقة',
                    'سرعة الحركة' => '20 م/دقيقة'
                ],
                'features' => [
                    'تحكم عن بعد',
                    'نظام أمان متقدم',
                    'حركة سلسة',
                    'صيانة سهلة',
                    'كفاءة عالية'
                ],
                'applications' => [
                    'المصانع',
                    'المستودعات',
                    'ورش الإصلاح',
                    'محطات الطاقة'
                ],
                'warranty' => 'ضمان شامل لمدة 5 سنوات',
                'is_active' => true,
                'is_featured' => true,
                'is_new' => false,
                'is_bestseller' => true,
                'sort_order' => 3,
                'image' => '/images/products/overhead-crane.svg'
            ],
            [
                'name' => [
                    'ar' => 'رافعة شوكية كهربائية',
                    'en' => 'Electric Forklift'
                ],
                'slug' => 'electric-forklift',
                'short_description' => [
                    'ar' => 'رافعة شوكية كهربائية صديقة للبيئة',
                    'en' => 'Environmentally friendly electric forklift'
                ],
                'description' => [
                    'ar' => 'رافعة شوكية كهربائية صديقة للبيئة مصممة للعمل في البيئات المغلقة.',
                    'en' => 'Environmentally friendly electric forklift designed for indoor operations.'
                ],
                'price' => 180000,
                'sku' => 'FORK-ELEC-001',
                'model' => 'EF-3T',
                'brand' => 'Revira',
                'country_of_origin' => 'اليابان',
                'category_id' => 9, // Forklifts
                'technical_specifications' => [
                    'الحمولة القصوى' => '3 طن',
                    'ارتفاع الرفع' => '6 متر',
                    'البطارية' => '48V/400Ah',
                    'وقت الشحن' => '8 ساعات',
                    'الوزن' => '3500kg'
                ],
                'features' => [
                    'صديقة للبيئة',
                    'ضجيج منخفض',
                    'تكلفة تشغيل منخفضة',
                    'صيانة سهلة',
                    'أمان عالي'
                ],
                'applications' => [
                    'المستودعات',
                    'المراكز التجارية',
                    'المصانع',
                    'المطارات'
                ],
                'warranty' => 'ضمان شامل لمدة 3 سنوات',
                'is_active' => true,
                'is_featured' => false,
                'is_new' => true,
                'is_bestseller' => false,
                'sort_order' => 4,
                'image' => '/images/products/electric-forklift.svg'
            ],
            [
                'name' => [
                    'ar' => 'مقياس رقمي دقيق',
                    'en' => 'Digital Precision Caliper'
                ],
                'slug' => 'digital-precision-caliper',
                'short_description' => [
                    'ar' => 'مقياس رقمي دقيق للقياسات الصناعية',
                    'en' => 'Digital precision caliper for industrial measurements'
                ],
                'description' => [
                    'ar' => 'مقياس رقمي دقيق مصمم للقياسات الصناعية عالية الدقة.',
                    'en' => 'Digital precision caliper designed for high-precision industrial measurements.'
                ],
                'price' => 500,
                'sku' => 'CAL-DIG-001',
                'model' => 'DC-200',
                'brand' => 'Revira',
                'country_of_origin' => 'سويسرا',
                'category_id' => 3, // Measuring Tools
                'technical_specifications' => [
                    'نطاق القياس' => '0-200mm',
                    'الدقة' => '±0.02mm',
                    'دقة العرض' => '0.01mm',
                    'المادة' => 'فولاذ مقوى',
                    'الحماية' => 'IP54'
                ],
                'features' => [
                    'عرض رقمي واضح',
                    'دقة عالية',
                    'مقاومة للصدمات',
                    'بطارية طويلة العمر',
                    'صفر تلقائي'
                ],
                'applications' => [
                    'القياسات الصناعية',
                    'مراقبة الجودة',
                    'المعامل',
                    'ورش الإصلاح'
                ],
                'warranty' => 'ضمان شامل لمدة سنة واحدة',
                'is_active' => true,
                'is_featured' => false,
                'is_new' => false,
                'is_bestseller' => true,
                'sort_order' => 5,
                'image' => '/images/products/caliper.svg'
            ]
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
} 