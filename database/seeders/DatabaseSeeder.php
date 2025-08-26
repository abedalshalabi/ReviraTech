<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AdminUserSeeder::class,
            LanguageSeeder::class,
            SettingSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            SliderSeeder::class,
            NewsSeeder::class,
            AgentSeeder::class,
        ]);
    }
}
