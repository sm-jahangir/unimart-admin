<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Stock;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        $purchase = Purchase::where('reference_no', 'PUR-2026-001')->firstOrFail();

        $headphones = Product::where('sku', 'PRD-001')->firstOrFail();
        $speaker = Product::where('sku', 'PRD-002')->firstOrFail();
        $honey = Product::where('sku', 'PRD-003')->firstOrFail();

        $lines = [
            [
                'item' => $headphones,
                'variation_names' => 'Black',
                'sku' => 'PRD-001-BLK',
                'price' => 4500,
                'quantity' => 15,
            ],
            [
                'item' => $speaker,
                'variation_names' => null,
                'sku' => 'PRD-002',
                'price' => 1800,
                'quantity' => 30,
            ],
            [
                'item' => $honey,
                'variation_names' => null,
                'sku' => 'PRD-003',
                'price' => 320,
                'quantity' => 100,
            ],
        ];

        foreach ($lines as $line) {
            Stock::firstOrCreate(
                [
                    'model_type' => Purchase::class,
                    'model_id' => $purchase->id,
                    'item_type' => $line['item']::class,
                    'item_id' => $line['item']->id,
                    'sku' => $line['sku'],
                ],
                [
                    'product_id' => $line['item']->id,
                    'variation_names' => $line['variation_names'],
                    'price' => $line['price'],
                    'quantity' => $line['quantity'],
                    'subtotal' => $line['price'] * $line['quantity'],
                    'total' => $line['price'] * $line['quantity'],
                    'status' => Status::ACTIVE,
                ],
            );
        }
    }
}
