<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function registerLayout(){
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|min:3', 
            'email' => 'required|email|unique:users,email', 
            'password' => 'required|min:5', 
            'password_confirmation' => 'required|same:password|min:5', 
        ]);
        
        
        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('loginLayout')->with('success', 'User berhasil register!');
    }


    public function loginLayout(){
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            // 'username' => 'required|min:3',
            'tipeLogin' => 'required|min:3',
            'password' => 'required',
        ]);

        $loginField = filter_var($request->input('tipeLogin'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $loginField => $request->input('tipeLogin'),
            'password' => $request->input('password'),
        ];


        if (Auth::attempt($credentials)) {
            return redirect()->route('subscriptions.plans')->with('success', 'User berhasil login!');
        } else {
            Session::flashInput($request->input());
            return redirect()->route('loginLayout')->with('error', 'Username, email, atau Password salah!');
        }
    }

    public function logout(){
        auth()->logout();
        return redirect('/')->with('success','Berhasil logout!');
    }

}
