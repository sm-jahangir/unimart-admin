<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ChangePasswordRequest;
use App\Http\Requests\Backend\UpdateProfileRequest;
use Illuminate\Support\Facades\Gate;

class ProfileController extends Controller
{
    /**
     * Show the profile edit form for the logged-in user.
     */
    public function index()
    {
        Gate::authorize('app.profile.update');

        return view('backend.profile.index');
    }

    /**
     * Update the logged-in user's profile.
     */
    public function update(UpdateProfileRequest $request)
    {
        Gate::authorize('app.profile.update');

        $user = $request->user();
        $user->update($request->safe()->only(['name', 'email']));

        if ($request->hasFile('avatar')) {
            $user->deleteAvatar();
            $user->update(['avatar' => $request->file('avatar')->store('users', 'public')]);
        }

        return back()->with('success', 'Profile successfully updated.');
    }

    /**
     * Show the change-password form.
     */
    public function changepass()
    {
        Gate::authorize('app.profile.update');

        return view('backend.profile.password-change');
    }

    /**
     * Change the logged-in user's password and log them out.
     */
    public function changepassword(ChangePasswordRequest $request)
    {
        // The current_password rule has already verified the old password.
        $request->user()->update(['password' => $request->validated('password')]);

        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Password successfully changed. Please log in again.');
    }
}
