<?php

namespace Database\Seeders;

use App\Models\ProductAttribute;
use App\Models\ProductAttributeOption;
use Illuminate\Database\Seeder;

class ProductAttributeOptionSeeder extends Seeder
{
    public function run(): void
    {
        $options = [
            'Color' => ['Red', 'Blue', 'Black', 'White', 'Green'],
            'Size' => ['S', 'M', 'L', 'XL', 'XXL'],
            'Weight' => ['250g', '500g', '1kg', '2kg'],
            'Material' => ['Cotton', 'Leather', 'Plastic', 'Steel'],
        ];

        foreach ($options as $attributeName => $values) {
            $attribute = ProductAttribute::where('name', $attributeName)->firstOrFail();

            foreach ($values as $value) {
                ProductAttributeOption::firstOrCreate([
                    'product_attribute_id' => $attribute->id,
                    'name' => $value,
                ]);
            }
        }
    }
}
