<?php

namespace App\Http\Controllers\Subscriptions\Account;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubsController extends Controller
{
    public function index()
    {
        return view('account.subs.index');
    }
    public function cancel(Request $request)
    {

        // $yearSubs = $request->user()->subscription('Year');
        // $monthSubs = $request->user()->subscription('Monthly');
        // // dd('work');

        // if ($yearSubs) {
        //     // dd('work');
        //     $yearSubs->cancel();
        //     return redirect()->route('account')->with('success', 'Cancel subs success');
        // } else if ($monthSubs){
        //     // dd('work');
        //     $monthSubs->cancel();
        //     return redirect()->route('account')->with('success', 'Cancel subs success');
        // }

        $subs = $request->user()->subscription('default');
        // dd($subs);
        $subs->cancel();
        return redirect()->route('account')->with('success', 'Berhasil berhenti subs!');
    }
    public function resumeIndex()
    {
        return view('account.subs.index');
    }

    public function resumeStore(Request $request)
    {
        $subs = $request->user()->subscription('default');
        // dd($subs);
        $subs->resume();
        return redirect()->route('account')->with('success', 'Berhasil melanjutkan subs!');
    }
}
