<?php

namespace Database\Seeders;

use App\Models\ProductAttribute;
use Illuminate\Database\Seeder;

class ProductAttributeSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Color', 'Size', 'Weight', 'Material'] as $name) {
            ProductAttribute::firstOrCreate(compact('name'));
        }
    }
}
