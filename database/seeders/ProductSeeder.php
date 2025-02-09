<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Ecommerce',
            'description' => 'This is an ecommerce product',
            'price' => '900',
            'rating' => '4',
            'discount' => '5',
            'category' => 'Category 1',
            'image' => 'product1.png',
        ]);
        Product::create([
            'name' => 'Hair Product',
            'description' => 'This is an Hair product',
            'price' => '1500',
            'rating' => '3',
            'discount' => '10',
            'category' => 'Category 2',
            'image' => 'product2.png',
        ]);
    }
}
