<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    return redirect('/login')->with('success', 'User berhasil register!');
}

    
    public function loginLayout(){
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
        'username' => 'required|min:3',
        'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return redirect('/plans')->with('success', 'User berhasil login!');
        } else {
            return redirect('/login')->with('error', 'Username atau Password salah!');
        }
    }

    public function logout(Request $request){
        auth()->logout();
        return redirect('/')->with('success','Berhasil logout!');
    }

}
