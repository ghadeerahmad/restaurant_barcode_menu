<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function registerPage()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        request()->validate([
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|max:255',
        ]);
        $data['email'] = $request['email'];
        $data['password'] = Hash::make($request['password']);
        $user = User::create($data);
        if ($user) {
            return back()->with(['success' => __('messages.user_create_success')]);
        }
    }
    public function loginPage()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $data = request()->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|max:255'
        ]);
        if (Auth::attempt($data)) {
            if (auth()->user()->is_admin == 1)
                return redirect('/admin/dashboard');
            return redirect('/dashboard');
        }
        return back()->withErrors(['errors' => __('messages.credential_error') ?? 'Wrong Email or Password']);
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
