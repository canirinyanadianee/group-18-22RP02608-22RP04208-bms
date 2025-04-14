<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;
use App\Models\User;
use App\Models\BloodBank;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Seed languages
        $languages = [
            ['code' => 'en', 'name' => 'English', 'native_name' => 'English'],
            ['code' => 'es', 'name' => 'Spanish', 'native_name' => 'Español'],
            ['code' => 'fr', 'name' => 'French', 'native_name' => 'Français'],
            ['code' => 'de', 'name' => 'German', 'native_name' => 'Deutsch'],
            ['code' => 'it', 'name' => 'Italian', 'native_name' => 'Italiano'],
            ['code' => 'pt', 'name' => 'Portuguese', 'native_name' => 'Português'],
            ['code' => 'ru', 'name' => 'Russian', 'native_name' => 'Русский'],
            ['code' => 'zh', 'name' => 'Chinese', 'native_name' => '中文'],
            ['code' => 'ja', 'name' => 'Japanese', 'native_name' => '日本語'],
            ['code' => 'ar', 'name' => 'Arabic', 'native_name' => 'العربية'],
        ];

        foreach ($languages as $language) {
            Language::create($language);
        }

        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@bms.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'phone' => '1234567890',
            'address' => 'Admin Address',
            'city' => 'Admin City',
            'state' => 'Admin State',
            'country' => 'Admin Country',
            'language_code' => 'en',
            'is_verified' => true
        ]);

        // Create sample blood bank
        BloodBank::create([
            'name' => 'Central Blood Bank',
            'address' => '123 Main Street',
            'city' => 'New York',
            'state' => 'NY',
            'country' => 'USA',
            'phone' => '1234567890',
            'email' => 'central@bloodbank.com',
            'license_number' => 'BB123456',
            'is_active' => true
        ]);
    }
}
