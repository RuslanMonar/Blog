<?php

namespace App\Http\Controllers;
use App\User;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function registerForm()
    {
        return view('pages.register');
    }
    public function register(Request $request)
    {
        $this->validate($request , [
            'name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);
        $user = User::add($request->all());
        $user->generatePassword($request->get('password'));
        return redirect('/login');
    }
    public function loginForm()
    {
        return view('pages.login');
    }
    public function login(Request $request)
    {
        $this->validate($request , [
            'name' => 'required',
            'password' => 'required',
        ]);
        $resault = Auth::attempt([
            'name' => $request->get('name'),
            'password' => $request->get('password')
        ]);
        return $resault ? redirect('/') : redirect()->back()->with('status' , 'Неправильный логин или пароль');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
