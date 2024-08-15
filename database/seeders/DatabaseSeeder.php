<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $users = [
            [
                'name' => 'Barış Bideratan',
                'email' => 'baris@emsal.com.tr',
            ],
            [
                'name' => 'İsa Öztaş',
                'email' => 'isa@emsal.com.tr',
            ],
        ];

        $userFactory = User::factory(); // Factory'i döngü dışında 1 kez oluştuyoruz.

        foreach ($users as $user) {
            $userFactory->create($user);
        }
    }
}
