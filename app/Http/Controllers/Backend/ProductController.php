<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Barcode;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    public function index()
    {
        Gate::authorize('app.products.index');

        $products = Product::with(['category', 'brand', 'unit'])->latest()->paginate(15);

        return view('backend.products.index', [
            'products' => $products,
            'stats' => [
                'total' => Product::count(),
                'published' => Product::published()->count(),
                'outOfStock' => 0, // wired when inventory sum is added
            ],
        ]);
    }

    public function create()
    {
        Gate::authorize('app.products.create');

        return view('backend.products.form', [
            'product' => new Product,
            'categories' => Category::orderBy('name')->get(),
            'brands' => Brand::orderBy('name')->get(),
            'units' => Unit::orderBy('name')->get(),
            'barcodes' => Barcode::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Gate::authorize('app.products.create');

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:100', 'unique:products,sku'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', 'unique:products,slug'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'brand_id' => ['nullable', 'integer', 'exists:brands,id'],
            'unit_id' => ['nullable', 'integer', 'exists:units,id'],
            'barcode_id' => ['nullable', 'integer', 'exists:barcodes,id'],
            'barcode_code' => ['nullable', 'digits_between:11,13', 'unique:products,barcode_code'],
            'buying_price' => ['nullable', 'numeric', 'min:0'],
            'selling_price' => ['required', 'numeric', 'min:0'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'offer_start_date' => ['nullable', 'date'],
            'offer_end_date' => ['nullable', 'date', 'after_or_equal:offer_start_date'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'integer', 'in:0,1'],
            'can_purchasable' => ['nullable', 'boolean'],
            'show_stock_out' => ['nullable', 'boolean'],
            'is_free_delivery' => ['nullable', 'boolean'],
            'refundable' => ['nullable', 'boolean'],
            'maximum_purchase_quantity' => ['nullable', 'integer', 'min:1'],
            'low_stock_quantity_warning' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['slug'] = $data['slug'] ?? null;
        $product = Product::create($data);

        return redirect()->route('app.products.index')->with('success', 'Product successfully added.');
    }

    public function edit(Product $product)
    {
        Gate::authorize('app.products.edit');

        return view('backend.products.form', [
            'product' => $product,
            'categories' => Category::orderBy('name')->get(),
            'brands' => Brand::orderBy('name')->get(),
            'units' => Unit::orderBy('name')->get(),
            'barcodes' => Barcode::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        Gate::authorize('app.products.edit');

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:100', 'unique:products,sku,'.$product->id],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', 'unique:products,slug,'.$product->id],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'brand_id' => ['nullable', 'integer', 'exists:brands,id'],
            'unit_id' => ['nullable', 'integer', 'exists:units,id'],
            'barcode_id' => ['nullable', 'integer', 'exists:barcodes,id'],
            'barcode_code' => ['nullable', 'digits_between:11,13', 'unique:products,barcode_code,'.$product->id],
            'buying_price' => ['nullable', 'numeric', 'min:0'],
            'selling_price' => ['required', 'numeric', 'min:0'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'offer_start_date' => ['nullable', 'date'],
            'offer_end_date' => ['nullable', 'date', 'after_or_equal:offer_start_date'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'integer', 'in:0,1'],
            'can_purchasable' => ['nullable', 'boolean'],
            'show_stock_out' => ['nullable', 'boolean'],
            'is_free_delivery' => ['nullable', 'boolean'],
            'refundable' => ['nullable', 'boolean'],
            'maximum_purchase_quantity' => ['nullable', 'integer', 'min:1'],
            'low_stock_quantity_warning' => ['nullable', 'integer', 'min:0'],
        ]);

        $product->update($data);

        return redirect()->route('app.products.index')->with('success', 'Product successfully updated.');
    }

    public function destroy(Product $product)
    {
        Gate::authorize('app.products.destroy');

        $product->delete(); // soft delete keeps history

        return back()->with('success', 'Product successfully deleted.');
    }
}
