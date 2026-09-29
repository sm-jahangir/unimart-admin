<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\RoleRequest;
use App\Models\Module;
use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('app.roles.index');

        $roles = Role::withCount('users')->withCount('permissions')->get();

        return view('backend.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('app.roles.create');

        return view('backend.roles.form', [
            'role' => new Role,
            'modules' => Module::with('permissions')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        Gate::authorize('app.roles.create');

        $role = Role::create([
            'name' => $request->validated('name'),
            'description' => $request->validated('description'),
            'slug' => Str::slug($request->validated('name')),
        ]);

        $role->permissions()->sync($request->validated('permissions'));

        return redirect()->route('app.roles.index')->with('success', 'Role successfully added.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        Gate::authorize('app.roles.edit');

        $role->load('permissions');

        return view('backend.roles.form', [
            'role' => $role,
            'modules' => Module::with('permissions')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role)
    {
        Gate::authorize('app.roles.edit');

        $role->update([
            'name' => $request->validated('name'),
            'description' => $request->validated('description'),
            'slug' => Str::slug($request->validated('name')),
        ]);

        $role->permissions()->sync($request->validated('permissions'));

        return redirect()->route('app.roles.index')->with('success', 'Role successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        Gate::authorize('app.roles.destroy');

        if (! $role->deletable) {
            return back()->with('error', 'You cannot delete a system role.');
        }

        $role->delete();

        return back()->with('success', 'Role successfully deleted.');
    }
}
