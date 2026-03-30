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
            ['key' => 'facebook_url', 'value' => '#'],
            ['key' => 'twitter_url', 'value' => '#'],
            ['key' => 'instagram_url', 'value' => '#'],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::updateOrCreate(['key' => $setting['key']], ['value' => $setting['value']]);
        }
    }
}
