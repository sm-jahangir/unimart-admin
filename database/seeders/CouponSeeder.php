<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = [
            [
                'name' => 'Eid Special 10%',
                'code' => 'EID10',
                'discount' => 10,
                'discount_type' => 1, // 1 = percent, 0 = flat
                'start_date' => now()->subDays(5),
                'end_date' => now()->addDays(25),
                'minimum_order' => 1000,
                'maximum_discount' => 500,
                'limit_per_user' => 1,
                'description' => '10% off on orders above 1000 during Eid.',
            ],
            [
                'name' => 'New User 100 Off',
                'code' => 'NEW100',
                'discount' => 100,
                'discount_type' => 0,
                'start_date' => now()->subDays(30),
                'end_date' => now()->addMonths(6),
                'minimum_order' => 500,
                'maximum_discount' => 100,
                'limit_per_user' => 1,
                'description' => 'Flat 100 off for new customers.',
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::firstOrCreate(['code' => $coupon['code']], $coupon);
        }
    }
}
