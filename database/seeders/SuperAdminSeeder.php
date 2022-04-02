<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'Almamun',
            'email' => 'hamimalmizan@protonmail.com',
            'temp_password' => Hash::make('almamun123'),
            'isTemp' => 1,
            'role' => 1,
        ]);
    }
}
