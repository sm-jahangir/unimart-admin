<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CouponController extends Controller
{
    public function index()
    {
        Gate::authorize('app.coupons.index');

        $coupons = Coupon::latest()->paginate(15);

        return view('backend.coupons.index', compact('coupons'));
    }

    public function create()
    {
        Gate::authorize('app.coupons.create');

        return view('backend.coupons.form', ['coupon' => new Coupon]);
    }

    public function store(Request $request)
    {
        Gate::authorize('app.coupons.create');

        $data = $this->validated($request);
        Coupon::create($data + ['code' => strtoupper($data['code'])]);

        return redirect()->route('app.coupons.index')->with('success', 'Coupon successfully added.');
    }

    public function edit(Coupon $coupon)
    {
        Gate::authorize('app.coupons.edit');

        return view('backend.coupons.form', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        Gate::authorize('app.coupons.edit');

        $data = $this->validated($request, $coupon);
        $coupon->update($data + ['code' => strtoupper($data['code'])]);

        return redirect()->route('app.coupons.index')->with('success', 'Coupon successfully updated.');
    }

    public function destroy(Coupon $coupon)
    {
        Gate::authorize('app.coupons.destroy');

        $coupon->delete();

        return back()->with('success', 'Coupon successfully deleted.');
    }

    private function validated(Request $request, ?Coupon $coupon = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:coupons,code'.($coupon?->id ? ','.$coupon->id : '')],
            'discount' => ['required', 'numeric', 'min:0'],
            'discount_type' => ['required', 'integer', 'in:0,1'], // 0 = flat, 1 = percent
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'minimum_order' => ['nullable', 'numeric', 'min:0'],
            'maximum_discount' => ['nullable', 'numeric', 'min:0'],
            'limit_per_user' => ['nullable', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);
    }
}
