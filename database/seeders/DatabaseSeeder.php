<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        User::factory(9)->create([
            'is_admin' => 1
        ]);

        User::factory(18)->create([
            'is_admin' => 0
        ]);

        Product::factory(36)->create();
    }
}