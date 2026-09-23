<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Roles
        $roles = [
            ['id' => 1, 'name' => 'Super Admin', 'display_name' => 'Administrator'],
            ['id' => 2, 'name' => 'Guru', 'display_name' => 'Tenaga Pendidik'],
            ['id' => 3, 'name' => 'Siswa', 'display_name' => 'Pelajar / Peserta'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['id' => $role['id']],
                [
                    'name' => $role['name'],
                    'display_name' => $role['display_name'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // 2. Seed Default Global Settings
        $settings = [
            'app_name' => 'VxAI Coding Lab',
            'app_tagline' => 'Platform Belajar Koding & AI Interaktif',
            'primary_color' => '#2563EB',
            'maintenance_mode' => 'false',
            'adsense_client_id' => '',
            'adsense_status' => 'false',
            'ads_txt_content' => "# Format Ads.txt:\n# google.com, pub-XXXXXXXXXXXXXXXX, DIRECT, f08c47fec0942fa0",
            'contact_email' => 'admin@vxai.online',
        ];

        foreach ($settings as $key => $val) {
            DB::table('global_settings')->updateOrInsert(
                ['setting_key' => $key],
                [
                    'setting_value' => $val,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // 3. Ensure Default Admin Account Exists
        if (!DB::table('users')->where('email', 'admin@vxai.online')->exists()) {
            DB::table('users')->insert([
                'name' => 'Super Admin VxAI',
                'email' => 'admin@vxai.online',
                'password' => Hash::make('rahasia123'),
                'role_id' => 1,
                'xp' => 0,
                'level' => 99,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
