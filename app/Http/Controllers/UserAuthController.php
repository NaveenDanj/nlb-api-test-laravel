<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserAuthController extends Controller{

    public function login(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken('default')->plainTextToken;

    }


    public function register(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:users',
            'wallet_id' => 'required|string|unique:users|max:255',
            'nic' => 'required|string|unique:users|max:12',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'wallet_id' => $request->wallet_id,
            'nic' => $request->nic,
            'password' => Hash::make($request->password),
        ]);


        return $user->createToken('default')->plainTextToken;


    }


}
