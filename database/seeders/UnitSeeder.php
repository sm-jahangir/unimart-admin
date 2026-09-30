<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            ['name' => 'Piece', 'code' => 'pcs'],
            ['name' => 'Kilogram', 'code' => 'kg'],
            ['name' => 'Gram', 'code' => 'g'],
            ['name' => 'Litre', 'code' => 'l'],
            ['name' => 'Dozen', 'code' => 'dz'],
            ['name' => 'Box', 'code' => 'box'],
        ];

        foreach ($units as $unit) {
            Unit::firstOrCreate(['code' => $unit['code']], $unit + ['status' => Status::ACTIVE]);
        }
    }
}
