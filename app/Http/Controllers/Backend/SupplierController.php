<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SupplierController extends Controller
{
    public function index()
    {
        Gate::authorize('app.suppliers.index');

        $suppliers = Supplier::withCount('purchases')->latest()->paginate(15);

        return view('backend.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        Gate::authorize('app.suppliers.create');

        return view('backend.suppliers.form', ['supplier' => new Supplier]);
    }

    public function store(Request $request)
    {
        Gate::authorize('app.suppliers.create');

        Supplier::create($this->validated($request));

        return redirect()->route('app.suppliers.index')->with('success', 'Supplier successfully added.');
    }

    public function edit(Supplier $supplier)
    {
        Gate::authorize('app.suppliers.edit');

        return view('backend.suppliers.form', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        Gate::authorize('app.suppliers.edit');

        $supplier->update($this->validated($request));

        return redirect()->route('app.suppliers.index')->with('success', 'Supplier successfully updated.');
    }

    public function destroy(Supplier $supplier)
    {
        Gate::authorize('app.suppliers.destroy');

        $supplier->delete();

        return back()->with('success', 'Supplier successfully deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'company' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);
    }
}
