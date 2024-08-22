<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Activity;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        Category::factory(5)->create();
        Supplier::factory(5)->create();
        Product::factory(5)->create();
        Activity::factory(5)->create();


        // DB::table('suppliers')->insert([
        //     [
        //         'name' => 'Distributor A',
        //         'no_telepon' => '0123456789',
        //     ],
        //     [
        //         'name' => 'Distributor B',
        //         'no_telepon' => '0987654321',
        //     ],
        // ]);
    }
}
