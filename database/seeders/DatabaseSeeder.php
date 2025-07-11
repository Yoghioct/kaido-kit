<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'sadmin',
            'email' => 'sadmin@admin.com',
            'username' => 'sadmin',
            'password' => Hash::make('p455w0rd'),
        ]);

        //call BookSeeder
        // $this->call(
        //     [
        //         BookSeeder::class,
        //         PostSeeder::class,
        //         ContactSeeder::class,
        //     ]
        // );
    }
}
