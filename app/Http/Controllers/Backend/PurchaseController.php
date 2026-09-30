<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Support\Facades\Gate;

class PurchaseController extends Controller
{
    public function index()
    {
        Gate::authorize('app.purchases.index');

        $purchases = Purchase::with('supplier')->latest('date')->paginate(15);

        return view('backend.purchases.index', compact('purchases'));
    }

    public function show(Purchase $purchase)
    {
        Gate::authorize('app.purchases.index');

        $purchase->load(['supplier', 'stocks.product']);

        return view('backend.purchases.show', compact('purchase'));
    }
}
