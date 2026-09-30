<?php

namespace Database\Seeders;

use App\Enums\PurchasePaymentStatus;
use App\Enums\PurchaseStatus;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    public function run(): void
    {
        $supplier = Supplier::where('company', 'Dhaka Traders Ltd.')->firstOrFail();
        $techSupplier = Supplier::where('company', 'TechSource Asia')->firstOrFail();

        $purchases = [
            [
                'supplier_id' => $techSupplier->id,
                'reference_no' => 'PUR-2026-001',
                'date' => now()->subDays(10),
                'subtotal' => 126000,
                'tax' => 0,
                'discount' => 6000,
                'total' => 120000,
                'status' => PurchaseStatus::RECEIVED,
                'payment_status' => PurchasePaymentStatus::PAID,
                'note' => 'Initial stock for headphones and speakers.',
            ],
            [
                'supplier_id' => $supplier->id,
                'reference_no' => 'PUR-2026-002',
                'date' => now()->subDays(3),
                'subtotal' => 32000,
                'tax' => 0,
                'discount' => 0,
                'total' => 32000,
                'status' => PurchaseStatus::ORDERED,
                'payment_status' => PurchasePaymentStatus::PENDING,
                'note' => 'Grocery restock, expected next week.',
            ],
        ];

        foreach ($purchases as $purchase) {
            Purchase::firstOrCreate(['reference_no' => $purchase['reference_no']], $purchase);
        }
    }
}
