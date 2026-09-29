<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreUserRequest;
use App\Http\Requests\Backend\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('app.users.index');

        $users = User::with('role')->latest()->paginate(15);

        return view('backend.users.index', [
            'users' => $users,
            'stats' => [
                'total' => User::count(),
                'active' => User::where('status', true)->count(),
                'inactive' => User::where('status', false)->count(),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('app.users.create');

        return view('backend.users.form', ['roles' => Role::orderBy('name')->get(), 'user' => new User]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        Gate::authorize('app.users.create');

        $user = User::create($request->safe()->except(['avatar', 'password_confirmation']));

        if ($request->hasFile('avatar')) {
            $user->update(['avatar' => $request->file('avatar')->store('users', 'public')]);
        }

        return redirect()
            ->route('app.users.index')
            ->with('success', 'User successfully added.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        Gate::authorize('app.users.edit');

        return view('backend.users.form', ['roles' => Role::orderBy('name')->get(), 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        Gate::authorize('app.users.edit');

        $attributes = $request->safe()->except(['avatar', 'password', 'password_confirmation']);

        // Keep the current password when the field is left empty.
        if ($request->filled('password')) {
            $attributes['password'] = $request->validated('password');
        }

        $user->update($attributes);

        if ($request->hasFile('avatar')) {
            $user->deleteAvatar();
            $user->update(['avatar' => $request->file('avatar')->store('users', 'public')]);
        }

        return redirect()
            ->route('app.users.index')
            ->with('success', 'User successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Gate::authorize('app.users.destroy');

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        // The deleting hook on the model removes the avatar file.
        $user->delete();

        return back()->with('success', 'User successfully deleted.');
    }

    /**
     * Toggle the active status of the given user.
     */
    public function statusChange(Request $request, User $user)
    {
        Gate::authorize('app.users.edit');

        $user->update(['status' => ! $user->status]);

        return back()->with('success', 'User status updated.');
    }
}
