<?php

namespace Database\Seeders;

use App\Enums\BarcodeType;
use App\Models\Barcode;
use Illuminate\Database\Seeder;

class BarcodeSeeder extends Seeder
{
    public function run(): void
    {
        // Only the symbologies we actually support (picqer-mapped).
        foreach (BarcodeType::names() as $name) {
            Barcode::firstOrCreate(compact('name'));
        }

        // Drop types we no longer keep, detaching products first.
        Barcode::whereNotIn('name', BarcodeType::names())->get()->each(function (Barcode $barcode) {
            $barcode->products()->update(['barcode_id' => null]);
            $barcode->delete();
        });
    }
}
