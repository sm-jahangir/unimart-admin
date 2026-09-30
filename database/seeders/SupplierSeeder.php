<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            ['company' => 'Dhaka Traders Ltd.', 'name' => 'Karim Uddin', 'email' => 'karim@dhakatraders.com', 'phone' => '+8801711000001', 'address' => 'Karwan Bazar, Dhaka'],
            ['company' => 'Global Import BD', 'name' => 'Rashed Alam', 'email' => 'rashed@globalimport.com', 'phone' => '+8801711000002', 'address' => 'Chittagong'],
            ['company' => 'TechSource Asia', 'name' => 'Ming Wei', 'email' => 'ming@techsource.cn', 'phone' => '+8613800138000', 'address' => 'Shenzhen, China'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::firstOrCreate(['company' => $supplier['company']], $supplier);
        }
    }
}
