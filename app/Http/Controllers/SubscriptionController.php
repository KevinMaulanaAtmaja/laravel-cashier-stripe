<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request){
        $intent = $request->user()->createSetupIntent();
        return view('subscriptions.checkout', compact('intent'));
    }
}
