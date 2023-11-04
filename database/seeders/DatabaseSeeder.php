<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Bank;
use App\Models\Category;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(LaratrustSeeder::class);

        $user = User::create([
            'name' => 'admin',
            'username' => 'admin',
            'password' => Hash::make(123456),
        ]);

        $user->addRole('super_admin');

    }
}
