<?php

namespace App\Http\Controllers;
use App\Mail\SubscribeEmail;
use App\Subscription;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    public function subscribe(Request $request)
    {
       $this->validate($request , [
          'email' => 'required|email|unique:subscriptions' 
       ]);
       $sub = Subscription::add($request->get('email'));
       Mail::to($sub->send(new SubscribeEmail($sub)));
       return redirect()->back()->with('status' , 'Провірте вашу почту');
    }
}
