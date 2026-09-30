<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeOption;
use App\Models\ProductVariation;
use Illuminate\Database\Seeder;

class ProductVariationSeeder extends Seeder
{
    public function run(): void
    {
        $product = Product::where('sku', 'PRD-001')->firstOrFail();

        $color = ProductAttribute::where('name', 'Color')->firstOrFail();
        $black = ProductAttributeOption::where('name', 'Black')->where('product_attribute_id', $color->id)->firstOrFail();
        $white = ProductAttributeOption::where('name', 'White')->where('product_attribute_id', $color->id)->firstOrFail();

        $variations = [
            ['option' => $black, 'price' => 6500, 'sku' => 'PRD-001-BLK', 'order' => 1],
            ['option' => $white, 'price' => 6700, 'sku' => 'PRD-001-WHT', 'order' => 2],
        ];

        foreach ($variations as $v) {
            ProductVariation::firstOrCreate(
                ['sku' => $v['sku']],
                [
                    'product_id' => $product->id,
                    'product_attribute_id' => $color->id,
                    'product_attribute_option_id' => $v['option']->id,
                    'price' => $v['price'],
                    'order' => $v['order'],
                ],
            );
        }
    }
}
