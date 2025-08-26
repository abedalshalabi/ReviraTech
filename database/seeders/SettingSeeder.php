<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // إعدادات عامة
            ['key' => 'site_name', 'value' => 'Revira Tech', 'type' => 'text', 'group' => 'general', 'description' => 'اسم الموقع'],
            ['key' => 'site_description', 'value' => 'شركة متخصصة في الآلات والمعدات الصناعية', 'type' => 'textarea', 'group' => 'general', 'description' => 'وصف الموقع'],
            ['key' => 'site_logo', 'value' => '/images/logo.png', 'type' => 'image', 'group' => 'general', 'description' => 'شعار الموقع'],
            ['key' => 'site_favicon', 'value' => '/images/favicon.png', 'type' => 'image', 'group' => 'general', 'description' => 'أيقونة الموقع'],
            
            // معلومات الاتصال
            ['key' => 'contact_email', 'value' => 'info@revira.com', 'type' => 'email', 'group' => 'contact', 'description' => 'البريد الإلكتروني للتواصل'],
            ['key' => 'contact_phone', 'value' => '+966 50 123 4567', 'type' => 'text', 'group' => 'contact', 'description' => 'رقم الهاتف'],
            ['key' => 'contact_address', 'value' => 'طولكرم - فلسطين', 'type' => 'textarea', 'group' => 'contact', 'description' => 'العنوان'],
            ['key' => 'contact_working_hours', 'value' => 'الأحد - الخميس: 8:00 ص - 6:00 م', 'type' => 'text', 'group' => 'contact', 'description' => 'ساعات العمل'],
            
            // وسائل التواصل الاجتماعي
            ['key' => 'social_facebook', 'value' => 'https://facebook.com/reviratech', 'type' => 'url', 'group' => 'social', 'description' => 'رابط فيسبوك'],
            ['key' => 'social_twitter', 'value' => 'https://twitter.com/reviratech', 'type' => 'url', 'group' => 'social', 'description' => 'رابط تويتر'],
            ['key' => 'social_linkedin', 'value' => 'https://linkedin.com/company/reviratech', 'type' => 'url', 'group' => 'social', 'description' => 'رابط لينكد إن'],
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/reviratech', 'type' => 'url', 'group' => 'social', 'description' => 'رابط إنستغرام'],
            ['key' => 'social_youtube', 'value' => 'https://youtube.com/reviratech', 'type' => 'url', 'group' => 'social', 'description' => 'رابط يوتيوب'],
            
            // إعدادات SEO
            ['key' => 'seo_google_analytics', 'value' => '', 'type' => 'text', 'group' => 'seo', 'description' => 'كود Google Analytics'],
            ['key' => 'seo_facebook_pixel', 'value' => '', 'type' => 'text', 'group' => 'seo', 'description' => 'كود Facebook Pixel'],
            ['key' => 'seo_google_verification', 'value' => '', 'type' => 'text', 'group' => 'seo', 'description' => 'كود التحقق من Google'],
            ['key' => 'seo_bing_verification', 'value' => '', 'type' => 'text', 'group' => 'seo', 'description' => 'كود التحقق من Bing'],
            
            // إعدادات البريد الإلكتروني
            ['key' => 'mailchimp_api_key', 'value' => '', 'type' => 'text', 'group' => 'email', 'description' => 'مفتاح API لـ Mailchimp'],
            ['key' => 'mailchimp_list_id', 'value' => '', 'type' => 'text', 'group' => 'email', 'description' => 'معرف قائمة Mailchimp'],
            
            // إعدادات الخريطة
            ['key' => 'google_maps_api_key', 'value' => '', 'type' => 'text', 'group' => 'map', 'description' => 'مفتاح API لـ Google Maps'],
            ['key' => 'map_latitude', 'value' => '24.7136', 'type' => 'text', 'group' => 'map', 'description' => 'خط العرض للموقع'],
            ['key' => 'map_longitude', 'value' => '46.6753', 'type' => 'text', 'group' => 'map', 'description' => 'خط الطول للموقع'],
            ['key' => 'map_zoom', 'value' => '15', 'type' => 'number', 'group' => 'map', 'description' => 'مستوى التكبير للخريطة'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
