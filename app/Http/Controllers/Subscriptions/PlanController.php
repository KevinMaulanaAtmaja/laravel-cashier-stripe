<?php

namespace App\Http\Controllers\Subscriptions;

use App\Models\Plan;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    public function index(){
        $plan = Plan::all();
        return view('subscriptions.plans', compact('plan'));
    }
}