<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'Electronics',
        ]);
        DB::table('categories')->insert([
            'name' => 'Kitchen Wares',
        ]);
        DB::table('categories')->insert([
            'name' => 'House Furnitures',
        ]);
        DB::table('categories')->insert([
            'name' => 'Toys & Games',
        ]);
        DB::table('categories')->insert([
            'name' => 'Instruments',
        ]);
        DB::table('categories')->insert([
            'name' => 'Clothes',
        ]);
        DB::table('categories')->insert([
            'name' => 'Health & Care',
        ]);
        DB::table('categories')->insert([
            'name' => 'Food & Drugs',
        ]);
        DB::table('categories')->insert([
            'name' => 'Pets Furnitures',
        ]);
        DB::table('categories')->insert([
            'name' => 'Others',
        ]);
    }
}
