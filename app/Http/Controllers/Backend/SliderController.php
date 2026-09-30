<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SliderController extends Controller
{
    public function index()
    {
        Gate::authorize('app.sliders.index');

        $sliders = Slider::latest()->paginate(15);

        return view('backend.sliders.index', compact('sliders'));
    }

    public function create()
    {
        Gate::authorize('app.sliders.create');

        return view('backend.sliders.form', ['slider' => new Slider]);
    }

    public function store(Request $request)
    {
        Gate::authorize('app.sliders.create');

        Slider::create($this->validated($request));

        return redirect()->route('app.sliders.index')->with('success', 'Slider successfully added.');
    }

    public function edit(Slider $slider)
    {
        Gate::authorize('app.sliders.edit');

        return view('backend.sliders.form', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        Gate::authorize('app.sliders.edit');

        $slider->update($this->validated($request));

        return redirect()->route('app.sliders.index')->with('success', 'Slider successfully updated.');
    }

    public function destroy(Slider $slider)
    {
        Gate::authorize('app.sliders.destroy');

        $slider->delete();

        return back()->with('success', 'Slider successfully deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'link' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'integer', 'in:0,1'],
        ]);
    }
}
