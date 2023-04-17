<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory(100)->create()->each(function (Product $product) {
            $product->categories()->attach(
                \App\Models\Category::inRandomOrder()->limit(3)->pluck('id')->toArray()
            );
        });
    }
}
