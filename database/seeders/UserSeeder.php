<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // <-- tambahkan ini biar bisa pakai model User
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Data admin kampus
        User::create([
            'name' => 'Admin Kampus',
            'email' => 'admin@eventhub.com',
            'password' => Hash::make('123456'), // gunakan Hash, bukan bcrypt biasa
            'role' => 'admin',
        ]);

        // Data panitia contoh
        User::create([
            'name' => 'Panitia HIMSI',
            'email' => 'panitia@eventhub.com',
            'password' => Hash::make('123456'),
            'role' => 'panitia',
        ]);

        // Data mahasiswa contoh
        User::create([
            'name' => 'Mahasiswa Unej',
            'email' => 'mahasiswa@eventhub.com',
            'password' => Hash::make('123456'),
            'role' => 'mahasiswa',
        ]);
    }
}

