<?php

namespace App\Http\Controllers\Plan;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    public function index()
    {
        $plan = Plan::all();
        return view('subscriptions.plans', compact('plan'));
    }
}
