<?php

namespace Database\Seeders;

use App\Enums\Activity;
use App\Enums\Ask;
use App\Enums\Status;
use App\Models\Barcode;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSeo;
use App\Models\ProductTag;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Make sure the catalog basics exist before referencing them.
        $category = Category::firstOrCreate(
            ['slug' => 'electronics'],
            ['name' => 'Electronics', 'status' => 'published', 'sort_order' => 1],
        );
        $grocery = Category::firstOrCreate(
            ['slug' => 'grocery'],
            ['name' => 'Grocery', 'status' => 'published', 'sort_order' => 2],
        );
        $brand = Brand::firstOrCreate(
            ['slug' => 'acme-audio'],
            ['name' => 'Acme Audio', 'status' => 'published', 'featured' => true],
        );
        $fresh = Brand::firstOrCreate(
            ['slug' => 'freshfarm'],
            ['name' => 'FreshFarm', 'status' => 'published'],
        );

        $unit = Unit::where('code', 'pcs')->firstOrFail();
        $barcode = Barcode::where('name', 'EAN-13')->firstOrFail();

        $products = [
            [
                'name' => 'Wireless Headphones Pro',
                'sku' => 'PRD-001',
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'barcode_code' => '5901234123457',
                'buying_price' => 4500,
                'selling_price' => 6500,
                'discount' => 500,
                'offer_start_date' => now()->subDays(2),
                'offer_end_date' => now()->addDays(5),
                'description' => 'Over-ear wireless headphones with active noise cancellation and 40-hour battery life.',
                'tags' => ['audio', 'wireless', 'noise-cancelling'],
                'seo' => ['title' => 'Wireless Headphones Pro', 'description' => 'Premium wireless headphones with ANC.', 'meta_keyword' => ['headphones', 'wireless', 'audio']],
            ],
            [
                'name' => 'Bluetooth Speaker Mini',
                'sku' => 'PRD-002',
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'barcode_code' => '012345678905',
                'buying_price' => 1800,
                'selling_price' => 2600,
                'description' => 'Compact waterproof Bluetooth speaker with 12-hour playback.',
                'tags' => ['audio', 'speaker', 'portable'],
                'seo' => ['title' => 'Bluetooth Speaker Mini', 'description' => 'Waterproof portable speaker.', 'meta_keyword' => ['speaker', 'bluetooth']],
            ],
            [
                'name' => 'Organic Honey 500g',
                'sku' => 'PRD-003',
                'category_id' => $grocery->id,
                'brand_id' => $fresh->id,
                'buying_price' => 320,
                'selling_price' => 480,
                'description' => 'Raw organic honey collected from Sundarbans.',
                'tags' => ['organic', 'honey', 'grocery'],
                'seo' => ['title' => 'Organic Honey 500g', 'description' => 'Raw organic honey.', 'meta_keyword' => ['honey', 'organic']],
            ],
        ];

        foreach ($products as $data) {
            $product = Product::firstOrCreate(
                ['sku' => $data['sku']],
                [
                    'name' => $data['name'],
                    'category_id' => $data['category_id'],
                    'brand_id' => $data['brand_id'],
                    'barcode_id' => $barcode->id,
                    'barcode_code' => $data['barcode_code'] ?? null,
                    'unit_id' => $unit->id,
                    'buying_price' => $data['buying_price'],
                    'selling_price' => $data['selling_price'],
                    'discount' => $data['discount'] ?? 0,
                    'offer_start_date' => $data['offer_start_date'] ?? null,
                    'offer_end_date' => $data['offer_end_date'] ?? null,
                    'description' => $data['description'],
                    'status' => Status::ACTIVE,
                    'can_purchasable' => Ask::YES,
                    'show_stock_out' => Activity::ENABLE,
                    'refundable' => Ask::YES,
                    'is_free_delivery' => Ask::NO,
                    'maximum_purchase_quantity' => 10,
                    'low_stock_quantity_warning' => 5,
                ],
            );

            foreach ($data['tags'] as $tag) {
                ProductTag::firstOrCreate(['product_id' => $product->id, 'name' => $tag]);
            }

            ProductSeo::firstOrCreate(
                ['product_id' => $product->id],
                $data['seo'],
            );
        }
    }
}
