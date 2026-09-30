<?php

namespace App\Http\Controllers\Backend;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        Gate::authorize('app.orders.index');

        $orders = Order::with('user')->latest('order_datetime')->paginate(15);

        return view('backend.orders.index', [
            'orders' => $orders,
            'statuses' => OrderStatus::cases(),
            'stats' => [
                'total' => Order::count(),
                'pending' => Order::where('status', OrderStatus::PENDING)->count(),
                'completed' => Order::where('status', OrderStatus::COMPLETED)->count(),
                'revenue' => (float) Order::where('payment_status', 2)->sum('total'),
            ],
        ]);
    }

    public function show(Order $order)
    {
        Gate::authorize('app.orders.index');

        $order->load(['user', 'coupons.coupon', 'transactions', 'items.product']);

        return view('backend.orders.show', compact('order'));
    }

    public function statusChange(Request $request, Order $order)
    {
        Gate::authorize('app.orders.edit');

        $data = $request->validate([
            'status' => ['required', Rule::enum(OrderStatus::class)],
        ]);

        $order->update($data);

        return back()->with('success', 'Order status updated to '.$order->refresh()->status->label().'.');
    }
}
