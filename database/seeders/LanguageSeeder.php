<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            [
                'name' => 'العربية',
                'code' => 'ar',
                'locale' => 'ar_SA',
                'flag' => 'ar',
                'is_rtl' => true,
                'is_active' => true,
                'is_default' => false,
                'sort_order' => 2,
            ],
            [
                'name' => 'English',
                'code' => 'en',
                'locale' => 'en_US',
                'flag' => 'us',
                'is_rtl' => false,
                'is_active' => true,
                'is_default' => true,
                'sort_order' => 1,
            ],
        ];

        foreach ($languages as $language) {
            Language::updateOrCreate(
                ['code' => $language['code']],
                $language
            );
        }
    }
}
