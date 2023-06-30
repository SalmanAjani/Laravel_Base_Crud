<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function login(Request $request){
        $formData = $request->validate([
            'loginname' => 'required',
            'loginpassword' => 'required'
        ]);

        if(auth()->attempt(['name' => $formData['loginname'], 'password' => $formData['loginpassword']])){
            $request->session()->regenerate();
        }

        return redirect('/');
    }

    public function logout(){
        auth()->logout();
        return redirect('/');
    }

    public function register(Request $request){
        $formData = $request->validate([
            'name' => ['required', 'min:3', 'max:200', Rule::unique('users', 'name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:3', 'max:200'],
        ]);

        $formData['password'] = bcrypt($formData['password']);
        $user = User::create($formData);
        auth()->login($user);
        return redirect('/');
    }
}
