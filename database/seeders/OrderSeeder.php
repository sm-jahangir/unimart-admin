<?php

namespace Database\Seeders;

use App\Enums\Ask;
use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Enums\PaymentGateway;
use App\Enums\PaymentStatus;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderCoupon;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'user@mail.com')->firstOrFail();
        $coupon = Coupon::where('code', 'EID10')->firstOrFail();

        $orders = [
            [
                'serial' => 'ORD-1001',
                'customer_name' => 'Jone Doe',
                'customer_phone' => '+8801711000111',
                'subtotal' => 9100,
                'discount' => 500,
                'delivery_charge' => 60,
                'total' => 8660,
                'status' => OrderStatus::COMPLETED,
                'payment_status' => PaymentStatus::PAID,
                'payment_method' => PaymentGateway::CASH_ON_DELIVERY,
                'paid' => true,
            ],
            [
                'serial' => 'ORD-1002',
                'customer_name' => 'Guest Customer',
                'customer_phone' => '+8801711000222',
                'user_id' => null,
                'subtotal' => 2600,
                'discount' => 0,
                'delivery_charge' => 60,
                'total' => 2660,
                'status' => OrderStatus::PROCESSING,
                'payment_status' => PaymentStatus::UNPAID,
                'payment_method' => PaymentGateway::CASH_ON_DELIVERY,
                'paid' => false,
            ],
            [
                'serial' => 'ORD-1003',
                'customer_name' => 'Jone Doe',
                'customer_phone' => '+8801711000111',
                'subtotal' => 4800,
                'discount' => 480,
                'delivery_charge' => 0,
                'total' => 4320,
                'status' => OrderStatus::PENDING,
                'payment_status' => PaymentStatus::UNPAID,
                'payment_method' => PaymentGateway::MOBILE_BANKING,
                'paid' => false,
            ],
        ];

        foreach ($orders as $data) {
            $userId = array_key_exists('user_id', $data) ? $data['user_id'] : $user->id;

            $order = Order::firstOrCreate(
                ['order_serial_no' => $data['serial']],
                [
                    'user_id' => $userId,
                    'customer_name' => $data['customer_name'],
                    'customer_phone' => $data['customer_phone'],
                    'customer_email' => $userId ? $user->email : null,
                    'subtotal' => $data['subtotal'],
                    'discount' => $data['discount'],
                    'delivery_charge' => $data['delivery_charge'],
                    'total' => $data['total'],
                    'order_datetime' => now()->subDays(rand(1, 10)),
                    'order_type' => OrderType::DELIVERY,
                    'payment_method' => $data['payment_method'],
                    'payment_status' => $data['payment_status'],
                    'status' => $data['status'],
                    'active' => Ask::YES,
                ],
            );

            if ($data['discount'] > 0) {
                OrderCoupon::firstOrCreate(
                    ['order_id' => $order->id, 'coupon_id' => $coupon->id],
                    ['user_id' => $order->user_id, 'discount' => $data['discount']],
                );
            }

            if ($data['paid']) {
                Transaction::firstOrCreate(
                    ['order_id' => $order->id, 'transaction_no' => 'TRX-'.$data['serial']],
                    [
                        'sign' => '+',
                        'amount' => $data['total'],
                        'payment_method' => 'cash',
                        'type' => 'payment',
                    ],
                );
            }
        }

        // Line items for the first order.
        $first = Order::where('order_serial_no', 'ORD-1001')->firstOrFail();
        $headphones = Product::where('sku', 'PRD-001')->firstOrFail();
        $speaker = Product::where('sku', 'PRD-002')->firstOrFail();

        $items = [
            ['item' => $headphones, 'quantity' => 1, 'variation' => 'Black'],
            ['item' => $speaker, 'quantity' => 1, 'variation' => null],
        ];

        foreach ($items as $line) {
            Stock::firstOrCreate(
                [
                    'model_type' => Order::class,
                    'model_id' => $first->id,
                    'item_type' => $line['item']::class,
                    'item_id' => $line['item']->id,
                ],
                [
                    'product_id' => $line['item']->id,
                    'variation_names' => $line['variation'],
                    'sku' => $line['item']->sku,
                    'price' => $line['item']->selling_price,
                    'quantity' => $line['quantity'],
                    'subtotal' => $line['item']->selling_price * $line['quantity'],
                    'total' => $line['item']->selling_price * $line['quantity'],
                ],
            );
        }
    }
}
