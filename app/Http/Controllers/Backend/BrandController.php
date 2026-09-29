<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\BrandRequest;
use App\Models\Brand;
use Illuminate\Support\Facades\Gate;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('app.brands.index');

        $brands = Brand::orderBy('sort_order')->orderBy('name')->paginate(15);

        return view('backend.brands.index', [
            'brands' => $brands,
            'stats' => [
                'total' => Brand::count(),
                'published' => Brand::where('status', 'published')->count(),
                'featured' => Brand::where('featured', true)->count(),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('app.brands.create');

        return view('backend.brands.form', ['brand' => new Brand]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        Gate::authorize('app.brands.create');

        $brand = Brand::create($request->safe()->except(['logo']));

        if ($request->hasFile('logo')) {
            $brand->update(['logo' => $request->file('logo')->store('brands', 'public')]);
        }

        return redirect()->route('app.brands.index')->with('success', 'Brand successfully added.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        Gate::authorize('app.brands.edit');

        return view('backend.brands.form', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, Brand $brand)
    {
        Gate::authorize('app.brands.edit');

        $brand->update($request->safe()->except(['logo']));

        if ($request->hasFile('logo')) {
            $brand->deleteLogo();
            $brand->update(['logo' => $request->file('logo')->store('brands', 'public')]);
        }

        return redirect()->route('app.brands.index')->with('success', 'Brand successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        Gate::authorize('app.brands.destroy');

        $brand->delete();

        return back()->with('success', 'Brand successfully deleted.');
    }
}
