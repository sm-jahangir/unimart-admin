<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Barcode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BarcodeController extends Controller
{
    public function index()
    {
        Gate::authorize('app.barcodes.index');

        $items = Barcode::latest()->paginate(15);

        return view('backend.barcodes.index', ['barcodes' => $items]);
    }

    public function create()
    {
        Gate::authorize('app.barcodes.create');

        return view('backend.barcodes.form', ['Barcode' => new Barcode]);
    }

    public function store(Request $request)
    {
        Gate::authorize('app.barcodes.create');

        $item = Barcode::create($this->validated($request));

        return redirect()->route('app.barcodes.index')->with('success', 'Barcode successfully added.');
    }

    public function edit(Barcode $Barcode)
    {
        Gate::authorize('app.barcodes.edit');

        return view('backend.barcodes.form', ['Barcode' => $Barcode]);
    }

    public function update(Request $request, Barcode $Barcode)
    {
        Gate::authorize('app.barcodes.edit');

        $Barcode->update($this->validated($request));

        return redirect()->route('app.barcodes.index')->with('success', 'Barcode successfully updated.');
    }

    public function destroy(Barcode $Barcode)
    {
        Gate::authorize('app.barcodes.destroy');

        $Barcode->delete();

        return back()->with('success', 'Barcode successfully deleted.');
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
