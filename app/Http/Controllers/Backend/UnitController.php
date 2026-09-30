<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UnitController extends Controller
{
    public function index()
    {
        Gate::authorize('app.units.index');

        $items = Unit::latest()->paginate(15);

        return view('backend.units.index', ['units' => $items]);
    }

    public function create()
    {
        Gate::authorize('app.units.create');

        return view('backend.units.form', ['Unit' => new Unit]);
    }

    public function store(Request $request)
    {
        Gate::authorize('app.units.create');

        $item = Unit::create($this->validated($request));

        return redirect()->route('app.units.index')->with('success', 'Unit successfully added.');
    }

    public function edit(Unit $Unit)
    {
        Gate::authorize('app.units.edit');

        return view('backend.units.form', ['Unit' => $Unit]);
    }

    public function update(Request $request, Unit $Unit)
    {
        Gate::authorize('app.units.edit');

        $Unit->update($this->validated($request));

        return redirect()->route('app.units.index')->with('success', 'Unit successfully updated.');
    }

    public function destroy(Unit $Unit)
    {
        Gate::authorize('app.units.destroy');

        $Unit->delete();

        return back()->with('success', 'Unit successfully deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate(self::rules());
    }

    public static function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'status' => ['nullable', 'integer', 'in:0,1'],
        ];
    }
}
