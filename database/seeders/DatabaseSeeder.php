<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmac.coffee',
            'password' => 'password',
            'is_admin' => true,
        ]);

        $this->call([
            SettingSeeder::class,
            HeroSlideSeeder::class,
            ProductCategorySeeder::class,
            ProductSeeder::class,
            NewsPostSeeder::class,
            GalleryItemSeeder::class,
            WashingStationSeeder::class,
            StatisticSeeder::class,
        ]);
    }
}
