<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role; // Jangan lupa import

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    Role::create(['name' => 'Admin', 'priority' => 99]);     // Admin punya prioritas tertinggi
    Role::create(['name' => 'Mahasiswa', 'priority' => 10]);
    Role::create(['name' => 'Staff', 'priority' => 20]);
    Role::create(['name' => 'BIMA', 'priority' => 30]);
    Role::create(['name' => 'PIC Ruangan', 'priority' => 40]);
    // Kita bisa tambahkan Rektorat nanti jika diperlukan
}
}