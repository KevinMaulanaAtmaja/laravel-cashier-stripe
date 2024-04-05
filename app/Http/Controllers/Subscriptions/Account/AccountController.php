<?php

namespace App\Http\Controllers\Subscriptions\Account;

use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function index()
    {
        return view('account.index');
    }
}
