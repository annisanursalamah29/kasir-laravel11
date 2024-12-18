<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class dataawal extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user = new User();
        $user->name = 'admin';
        $user->email = 'admin@kasir.com';
        $user->password = bcrypt('admin');
        $user->peran = 'admin';
        $user->save();
    }
}
