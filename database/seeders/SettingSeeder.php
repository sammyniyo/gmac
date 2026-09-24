<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'GMAC Coffee'],
            ['key' => 'site_description', 'value' => 'Green Mountain Arabica Coffee produces the best coffee that gives consumer the best Aroma'],
            ['key' => 'contact_email', 'value' => 'info@gmac.coffee'],
            ['key' => 'contact_phone', 'value' => '+250-783 053 415'],
            ['key' => 'contact_address', 'value' => 'KK 372 St, Kigali, Kicukiro, Rwanda'],
            ['key' => 'facebook_url', 'value' => 'https://www.facebook.com/profile.php?id=100088696975817'],
            ['key' => 'instagram_url', 'value' => 'https://www.instagram.com/gmac.coffee/'],
            ['key' => 'social_facebook', 'value' => 'https://www.facebook.com/profile.php?id=100088696975817'],
            ['key' => 'social_instagram', 'value' => 'https://www.instagram.com/gmac.coffee/'],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::updateOrCreate(['key' => $setting['key']], ['value' => $setting['value']]);
        }
    }
}
