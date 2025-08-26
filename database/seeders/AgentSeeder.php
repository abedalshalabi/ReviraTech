<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agent;

class AgentSeeder extends Seeder
{
    public function run(): void
    {
        $agents = [
            [
                'name' => [
                    'ar' => 'أحمد محمد',
                    'en' => 'Ahmed Mohammed'
                ],
                'company_name' => [
                    'ar' => 'شركة التقنية الصناعية',
                    'en' => 'Industrial Technology Company'
                ],
                'description' => [
                    'ar' => 'وكيل معتمد في منطقة الرياض، متخصص في بيع وصيانة الآلات الصناعية',
                    'en' => 'Authorized agent in Riyadh region, specialized in selling and maintaining industrial machinery'
                ],
                'email' => 'ahmed@industrial-tech.com',
                'phone' => '+966-11-123-4567',
                'website' => 'https://industrial-tech.com',
                'address' => [
                    'ar' => 'شارع الملك فهد، حي النزهة',
                    'en' => 'King Fahd Street, Al-Nuzha District'
                ],
                'city' => [
                    'ar' => 'الرياض',
                    'en' => 'Riyadh'
                ],
                'country' => [
                    'ar' => 'المملكة العربية السعودية',
                    'en' => 'Saudi Arabia'
                ],
                'latitude' => 24.7136,
                'longitude' => 46.6753,
                'working_hours' => [
                    'الأحد' => '08:00 - 17:00',
                    'الاثنين' => '08:00 - 17:00',
                    'الثلاثاء' => '08:00 - 17:00',
                    'الأربعاء' => '08:00 - 17:00',
                    'الخميس' => '08:00 - 17:00',
                    'الجمعة' => 'مغلق',
                    'السبت' => '09:00 - 14:00'
                ],
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => [
                    'ar' => 'محمد علي',
                    'en' => 'Mohammed Ali'
                ],
                'company_name' => [
                    'ar' => 'شركة جدة للمعدات الصناعية',
                    'en' => 'Jeddah Industrial Equipment Company'
                ],
                'description' => [
                    'ar' => 'وكيل معتمد في منطقة جدة، يقدم خدمات شاملة للآلات والمعدات الصناعية',
                    'en' => 'Authorized agent in Jeddah region, providing comprehensive services for industrial machinery and equipment'
                ],
                'email' => 'mohammed@jeddah-industrial.com',
                'phone' => '+966-12-987-6543',
                'website' => 'https://jeddah-industrial.com',
                'address' => [
                    'ar' => 'شارع التحلية، حي الشاطئ',
                    'en' => 'Tahlia Street, Al-Shati District'
                ],
                'city' => [
                    'ar' => 'جدة',
                    'en' => 'Jeddah'
                ],
                'country' => [
                    'ar' => 'المملكة العربية السعودية',
                    'en' => 'Saudi Arabia'
                ],
                'latitude' => 21.4858,
                'longitude' => 39.1925,
                'working_hours' => [
                    'الأحد' => '08:00 - 18:00',
                    'الاثنين' => '08:00 - 18:00',
                    'الثلاثاء' => '08:00 - 18:00',
                    'الأربعاء' => '08:00 - 18:00',
                    'الخميس' => '08:00 - 18:00',
                    'الجمعة' => 'مغلق',
                    'السبت' => '09:00 - 15:00'
                ],
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => [
                    'ar' => 'علي حسن',
                    'en' => 'Ali Hassan'
                ],
                'company_name' => [
                    'ar' => 'شركة الدمام للآلات الصناعية',
                    'en' => 'Dammam Industrial Machinery Company'
                ],
                'description' => [
                    'ar' => 'وكيل معتمد في المنطقة الشرقية، متخصص في معدات النفط والغاز',
                    'en' => 'Authorized agent in Eastern Province, specialized in oil and gas equipment'
                ],
                'email' => 'ali@dammam-industrial.com',
                'phone' => '+966-13-456-7890',
                'website' => 'https://dammam-industrial.com',
                'address' => [
                    'ar' => 'شارع الملك خالد، حي الشاطئ',
                    'en' => 'King Khalid Street, Al-Shati District'
                ],
                'city' => [
                    'ar' => 'الدمام',
                    'en' => 'Dammam'
                ],
                'country' => [
                    'ar' => 'المملكة العربية السعودية',
                    'en' => 'Saudi Arabia'
                ],
                'latitude' => 26.4207,
                'longitude' => 50.0888,
                'working_hours' => [
                    'الأحد' => '07:00 - 16:00',
                    'الاثنين' => '07:00 - 16:00',
                    'الثلاثاء' => '07:00 - 16:00',
                    'الأربعاء' => '07:00 - 16:00',
                    'الخميس' => '07:00 - 16:00',
                    'الجمعة' => 'مغلق',
                    'السبت' => '08:00 - 13:00'
                ],
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'name' => [
                    'ar' => 'فاطمة أحمد',
                    'en' => 'Fatima Ahmed'
                ],
                'company_name' => [
                    'ar' => 'شركة مكة للتقنيات الصناعية',
                    'en' => 'Makkah Industrial Technologies Company'
                ],
                'description' => [
                    'ar' => 'وكيل معتمد في منطقة مكة المكرمة، يقدم حلول صناعية متكاملة',
                    'en' => 'Authorized agent in Makkah region, providing integrated industrial solutions'
                ],
                'email' => 'fatima@makkah-tech.com',
                'phone' => '+966-12-345-6789',
                'website' => 'https://makkah-tech.com',
                'address' => [
                    'ar' => 'شارع العزيزية، حي العزيزية',
                    'en' => 'Al-Aziziyah Street, Al-Aziziyah District'
                ],
                'city' => [
                    'ar' => 'مكة المكرمة',
                    'en' => 'Makkah'
                ],
                'country' => [
                    'ar' => 'المملكة العربية السعودية',
                    'en' => 'Saudi Arabia'
                ],
                'latitude' => 21.4225,
                'longitude' => 39.8262,
                'working_hours' => [
                    'الأحد' => '08:00 - 17:00',
                    'الاثنين' => '08:00 - 17:00',
                    'الثلاثاء' => '08:00 - 17:00',
                    'الأربعاء' => '08:00 - 17:00',
                    'الخميس' => '08:00 - 17:00',
                    'الجمعة' => 'مغلق',
                    'السبت' => '09:00 - 14:00'
                ],
                'is_active' => true,
                'sort_order' => 4
            ]
        ];

        foreach ($agents as $agentData) {
            Agent::create($agentData);
        }
    }
} 