<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Gate;

class SubscriberController extends Controller
{
    public function index()
    {
        Gate::authorize('app.subscribers.index');

        $subscribers = Subscriber::latest()->paginate(15);

        return view('backend.subscribers.index', compact('subscribers'));
    }

    public function destroy(Subscriber $subscriber)
    {
        Gate::authorize('app.subscribers.destroy');

        $subscriber->delete();

        return back()->with('success', 'Subscriber successfully removed.');
    }
}
