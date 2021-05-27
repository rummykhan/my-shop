<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SellerController extends Controller
{
    public function login()
    {
        return view('seller.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        /** @var Seller $model */
        $model = Seller::query()->where('email', $request->get('email'))->first();

        if(!$model){
            return back()->with('error', 'Email or password is incorrect');
        }

        if (!Hash::check($request->get('password'), $model->password)) {
            return back()->with('error', 'Email or password is incorrect');
        }

        Auth::guard('seller')->login($model);

        return redirect()->route('items-index')
            ->with('success', 'Welcome ' . $model->name . '!');
    }

    public function logout()
    {
        Auth::guard('seller')->logout();

        return back()->with('success', 'Logged out!');
    }
}
