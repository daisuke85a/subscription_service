<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if ($_SERVER["REQUEST_URI"] !== '/') {
            $this->middleware('auth');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function all()
    {
        $user = Auth::user();

        if ($user) {
            $card = $user->card_brand;

            if ($user->role === 1) {
                $users = User::all();

                return view('admin')->with('users', $users);
            } else {
                return view('normal');
            }
        } else {
            return view('select');
        }
    }

}