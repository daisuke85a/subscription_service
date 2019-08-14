<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class SubscriptionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Request $request)
    {
        //実現性検証のため仮実装する

        $user = User::find(1);
        // Stripe::setApiKey();

        $sub = $user->newSubscription('main', 'plan_FcTvnzhh0xY6Yd')->create($request->stripeToken);
        var_dump($sub);
        return view('charge');
    }
}