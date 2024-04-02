<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $intent = $request->user()->createSetupIntent();
        // dd($request->plan);
        $plans = $request->plan;
        return view('subscriptions.checkout', compact('intent', 'plans'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);
        // dd($request->plan);
        
        $plan = Plan::where('slug', $request->plan)->first();
        // dd($plan);

        // $request->user()->newSubscription($plan->title, $plan->stripe_id)->create($request->token);
        $request->user()->newSubscription('default', $plan->stripe_id)->create($request->token);

        return redirect('/plans')->with('success', 'Berhasil subs!');
    }
}
