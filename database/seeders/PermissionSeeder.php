<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dashboard
        $moduleAppDashboard = Module::updateOrCreate(['name' => 'Admin Dashboard']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppDashboard->id,
            'name' => 'Access Dashboard',
            'slug' => 'app.dashboard',
        ]);

        // Settings
        $moduleAppSettings = Module::updateOrCreate(['name' => 'Settings']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppSettings->id,
            'name' => 'Access Settings',
            'slug' => 'app.settings.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppSettings->id,
            'name' => 'Update Settings',
            'slug' => 'app.settings.update',
        ]);

        // Profile
        $moduleAppProfile = Module::updateOrCreate(['name' => 'Profile']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppProfile->id,
            'name' => 'Update Profile',
            'slug' => 'app.profile.update',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppProfile->id,
            'name' => 'Update Password',
            'slug' => 'app.profile.password',
        ]);

        // Backups
        $moduleAppBackups = Module::updateOrCreate(['name' => 'Backups']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppBackups->id,
            'name' => 'Access Backups',
            'slug' => 'app.backups.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppBackups->id,
            'name' => 'Create Backups',
            'slug' => 'app.backups.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppBackups->id,
            'name' => 'Download Backups',
            'slug' => 'app.backups.download',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppBackups->id,
            'name' => 'Delete Backups',
            'slug' => 'app.backups.destroy',
        ]);

        // Brand management
        $moduleAppBrand = Module::updateOrCreate(['name' => 'Brand Management']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppBrand->id,
            'name' => 'Access Brands',
            'slug' => 'app.brands.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppBrand->id,
            'name' => 'Create Brand',
            'slug' => 'app.brands.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppBrand->id,
            'name' => 'Edit Brand',
            'slug' => 'app.brands.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppBrand->id,
            'name' => 'Delete Brand',
            'slug' => 'app.brands.destroy',
        ]);

        // Category management
        $moduleAppCategory = Module::updateOrCreate(['name' => 'Category Management']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppCategory->id,
            'name' => 'Access Categories',
            'slug' => 'app.categories.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppCategory->id,
            'name' => 'Create Category',
            'slug' => 'app.categories.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppCategory->id,
            'name' => 'Edit Category',
            'slug' => 'app.categories.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppCategory->id,
            'name' => 'Delete Category',
            'slug' => 'app.categories.destroy',
        ]);

        // Product management
        $moduleAppProduct = Module::updateOrCreate(['name' => 'Product Management']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppProduct->id,
            'name' => 'Access Products',
            'slug' => 'app.products.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppProduct->id,
            'name' => 'Create Product',
            'slug' => 'app.products.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppProduct->id,
            'name' => 'Edit Product',
            'slug' => 'app.products.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppProduct->id,
            'name' => 'Delete Product',
            'slug' => 'app.products.destroy',
        ]);

        // Order management
        $moduleAppOrder = Module::updateOrCreate(['name' => 'Order Management']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppOrder->id,
            'name' => 'Access Orders',
            'slug' => 'app.orders.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppOrder->id,
            'name' => 'Edit Order',
            'slug' => 'app.orders.edit',
        ]);

        // Coupon management
        $moduleAppCoupon = Module::updateOrCreate(['name' => 'Coupon Management']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppCoupon->id,
            'name' => 'Access Coupons',
            'slug' => 'app.coupons.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppCoupon->id,
            'name' => 'Create Coupon',
            'slug' => 'app.coupons.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppCoupon->id,
            'name' => 'Edit Coupon',
            'slug' => 'app.coupons.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppCoupon->id,
            'name' => 'Delete Coupon',
            'slug' => 'app.coupons.destroy',
        ]);

        // Supplier management
        $moduleAppSupplier = Module::updateOrCreate(['name' => 'Supplier Management']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppSupplier->id,
            'name' => 'Access Suppliers',
            'slug' => 'app.suppliers.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppSupplier->id,
            'name' => 'Create Supplier',
            'slug' => 'app.suppliers.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppSupplier->id,
            'name' => 'Edit Supplier',
            'slug' => 'app.suppliers.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppSupplier->id,
            'name' => 'Delete Supplier',
            'slug' => 'app.suppliers.destroy',
        ]);

        // Purchase management
        $moduleAppPurchase = Module::updateOrCreate(['name' => 'Purchase Management']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppPurchase->id,
            'name' => 'Access Purchases',
            'slug' => 'app.purchases.index',
        ]);

        // Storefront content (sliders, subscribers, units, barcodes)
        $moduleAppContent = Module::updateOrCreate(['name' => 'Storefront Content']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppContent->id,
            'name' => 'Access Sliders',
            'slug' => 'app.sliders.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppContent->id,
            'name' => 'Manage Sliders',
            'slug' => 'app.sliders.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppContent->id,
            'name' => 'Access Subscribers',
            'slug' => 'app.subscribers.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppContent->id,
            'name' => 'Delete Subscribers',
            'slug' => 'app.subscribers.destroy',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppContent->id,
            'name' => 'Access Units',
            'slug' => 'app.units.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppContent->id,
            'name' => 'Manage Units',
            'slug' => 'app.units.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppContent->id,
            'name' => 'Access Barcodes',
            'slug' => 'app.barcodes.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppContent->id,
            'name' => 'Manage Barcodes',
            'slug' => 'app.barcodes.create',
        ]);

        // Role management
        $moduleAppRole = Module::updateOrCreate(['name' => 'Role Management']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppRole->id,
            'name' => 'Access Roles',
            'slug' => 'app.roles.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppRole->id,
            'name' => 'Create Role',
            'slug' => 'app.roles.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppRole->id,
            'name' => 'Edit Role',
            'slug' => 'app.roles.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppRole->id,
            'name' => 'Delete Role',
            'slug' => 'app.roles.destroy',
        ]);

        // User management
        $moduleAppUser = Module::updateOrCreate(['name' => 'User Management']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppUser->id,
            'name' => 'Access Users',
            'slug' => 'app.users.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppUser->id,
            'name' => 'Create User',
            'slug' => 'app.users.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppUser->id,
            'name' => 'Edit User',
            'slug' => 'app.users.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppUser->id,
            'name' => 'Delete User',
            'slug' => 'app.users.destroy',
        ]);

        // Page management
        $moduleAppPage = Module::updateOrCreate(['name' => 'Page Management']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppPage->id,
            'name' => 'Access Pages',
            'slug' => 'app.pages.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppPage->id,
            'name' => 'Create Page',
            'slug' => 'app.pages.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppPage->id,
            'name' => 'Edit Page',
            'slug' => 'app.pages.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppPage->id,
            'name' => 'Delete Page',
            'slug' => 'app.pages.destroy',
        ]);

        // Post management
        $moduleAppPost = Module::updateOrCreate(['name' => 'Post Management']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppPost->id,
            'name' => 'Access Post',
            'slug' => 'app.posts.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppPost->id,
            'name' => 'Create Post',
            'slug' => 'app.posts.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppPost->id,
            'name' => 'Edit Post',
            'slug' => 'app.posts.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppPost->id,
            'name' => 'Delete Post',
            'slug' => 'app.posts.destroy',
        ]);

        // Menu management
        $moduleAppMenu = Module::updateOrCreate(['name' => 'Menu Management']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppMenu->id,
            'name' => 'Access Menus',
            'slug' => 'app.menus.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppMenu->id,
            'name' => 'Create Menu',
            'slug' => 'app.menus.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppMenu->id,
            'name' => 'Edit Menu',
            'slug' => 'app.menus.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppMenu->id,
            'name' => 'Delete Menu',
            'slug' => 'app.menus.destroy',
        ]);
    }
}
