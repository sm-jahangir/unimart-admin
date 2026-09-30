<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
        ]);

        // Catalog + inventory, in FK-safe order.
        $this->call([
            UnitSeeder::class,
            BarcodeSeeder::class,
            ProductAttributeSeeder::class,
            ProductAttributeOptionSeeder::class,
            SupplierSeeder::class,
            ProductSeeder::class,
            ProductVariationSeeder::class,
            PurchaseSeeder::class,
            StockSeeder::class,
            CouponSeeder::class,
            SliderSeeder::class,
            SubscriberSeeder::class,
            OrderSeeder::class,
        ]);

        $adminRole = Role::where('slug', 'admin')->firstOrFail();
        $userRole = Role::where('slug', 'user')->firstOrFail();

        // Find by email; everything else is updated on re-seed.
        User::updateOrCreate(
            ['email' => 'admin@mail.com'],
            ['role_id' => $adminRole->id, 'name' => 'Admin', 'password' => 'password', 'status' => true],
        );

        User::updateOrCreate(
            ['email' => 'user@mail.com'],
            ['role_id' => $userRole->id, 'name' => 'Jone Doe', 'password' => 'password', 'status' => true],
        );

        User::updateOrCreate(
            ['email' => 'guest@mail.com'],
            ['role_id' => $userRole->id, 'name' => 'Guest', 'password' => 'password', 'status' => true],
        );
    }
}
