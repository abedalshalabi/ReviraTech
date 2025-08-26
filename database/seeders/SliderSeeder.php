<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Slider;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        $sliders = [
            [
                'title' => [
                    'ar' => 'آلات ومعدات صناعية عالية الجودة',
                    'en' => 'High-Quality Industrial Machines & Equipment'
                ],
                'description' => [
                    'ar' => 'نقدم أفضل الآلات والمعدات الصناعية مع ضمان الجودة والخدمة المتميزة',
                    'en' => 'We provide the best industrial machines and equipment with quality guarantee and excellent service'
                ],
                'button_text' => [
                    'ar' => 'تصفح المنتجات',
                    'en' => 'Browse Products'
                ],
                'button_url' => '/products',
                'image' => '/images/sliders/slider1.svg',
                'sort_order' => 1,
                'is_active' => true,
                'start_date' => now(),
                'end_date' => now()->addYear()
            ],
            [
                'title' => [
                    'ar' => 'حلول صناعية متكاملة',
                    'en' => 'Integrated Industrial Solutions'
                ],
                'description' => [
                    'ar' => 'نقدم حلولاً صناعية متكاملة لجميع احتياجاتك مع فريق من الخبراء',
                    'en' => 'We provide integrated industrial solutions for all your needs with a team of experts'
                ],
                'button_text' => [
                    'ar' => 'تواصل معنا',
                    'en' => 'Contact Us'
                ],
                'button_url' => '/contact',
                'image' => '/images/sliders/slider2.svg',
                'sort_order' => 2,
                'is_active' => true,
                'start_date' => now(),
                'end_date' => now()->addYear()
            ],
            [
                'title' => [
                    'ar' => 'أحدث التقنيات الصناعية',
                    'en' => 'Latest Industrial Technologies'
                ],
                'description' => [
                    'ar' => 'نستورد أحدث التقنيات الصناعية من كبرى الشركات العالمية',
                    'en' => 'We import the latest industrial technologies from major global companies'
                ],
                'button_text' => [
                    'ar' => 'تعرف علينا',
                    'en' => 'About Us'
                ],
                'button_url' => '/about',
                'image' => '/images/sliders/slider3.svg',
                'sort_order' => 3,
                'is_active' => true,
                'start_date' => now(),
                'end_date' => now()->addYear()
            ]
        ];

        foreach ($sliders as $sliderData) {
            Slider::create($sliderData);
        }
    }
}