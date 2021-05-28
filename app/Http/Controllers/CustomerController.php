<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function login()
    {
        return view('customer.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        /** @var Customer $model */
        $model = Customer::query()->where('email', $request->get('email'))->first();

        if(!$model){
            return back()->with('error', 'Email or password is incorrect');
        }

        if (!Hash::check($request->get('password'), $model->password)) {
            return back()->with('error', 'Email or password is incorrect');
        }

        Auth::guard('customer')->login($model);

        return redirect()->route('home')
            ->with('success', 'Welcome ' . $model->name . '!');
    }

    public function logout()
    {
        Auth::guard('customer')->logout();

        return redirect()->route('home')->with('success', 'Logged out!');
    }
}
