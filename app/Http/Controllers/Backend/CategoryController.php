<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('app.categories.index');

        $categories = Category::with('parent')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return view('backend.categories.index', [
            'categories' => $categories,
            'stats' => [
                'total' => Category::count(),
                'published' => Category::where('status', 'published')->count(),
                'root' => Category::whereNull('parent_id')->count(),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('app.categories.create');

        return view('backend.categories.form', [
            'category' => new Category,
            'parents' => Category::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        Gate::authorize('app.categories.create');

        $category = Category::create($request->safe()->except(['image']));

        if ($request->hasFile('image')) {
            $category->update(['image' => $request->file('image')->store('categories', 'public')]);
        }

        return redirect()->route('app.categories.index')->with('success', 'Category successfully added.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        Gate::authorize('app.categories.edit');

        return view('backend.categories.form', [
            'category' => $category,
            'parents' => Category::where('id', '!=', $category->id)->orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        Gate::authorize('app.categories.edit');

        $category->update($request->safe()->except(['image']));

        if ($request->hasFile('image')) {
            $category->deleteImage();
            $category->update(['image' => $request->file('image')->store('categories', 'public')]);
        }

        return redirect()->route('app.categories.index')->with('success', 'Category successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        Gate::authorize('app.categories.destroy');

        $category->delete();

        return back()->with('success', 'Category successfully deleted.');
    }
}
