<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Jangan lupa import
use Illuminate\Support\Facades\Hash; // Jangan lupa import

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User Admin
        User::create([
            'name' => 'Randy Zenas Tanjung',
            'email' => 'admin@bakrie.ac.id',
            'password' => Hash::make('password'),
            'role_id' => 1, // ID untuk peran Admin
        ]);

        // User Mahasiswa
        User::create([
            'name' => 'Mahasiswa Bakrie',
            'email' => 'mahasiswa@bakrie.ac.id',
            'password' => Hash::make('password'),
            'role_id' => 2, // ID untuk peran Mahasiswa
        ]);

        // User Staff
        User::create([
            'name' => 'Dosen/Staff UB',
            'email' => 'staff@bakrie.ac.id',
            'password' => Hash::make('password'),
            'role_id' => 3, // ID untuk peran Staff
        ]);

        // User BIMA
        User::create([
            'name' => 'Staff BIMA',
            'email' => 'bima@bakrie.ac.id',
            'password' => Hash::make('password'),
            'role_id' => 4, // ID untuk peran BIMA
        ]);

        // User PIC Ruangan
        User::create([
            'name' => 'PIC Ruangan Utama',
            'email' => 'pic@bakrie.ac.id',
            'password' => Hash::make('password'),
            'role_id' => 5, // ID untuk peran PIC Ruangan
        ]);
    }
}