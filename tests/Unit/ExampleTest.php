<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
     class HomeController extends Controller
     {
         /**
          * Create a new controller instance.
          *
          * @return void
          */
         public function __construct()
         {
             $url = Request::all();
             var_dump($url);

             if ($url !== '/') {
                   $this->middleware('auth');
               }
         }

         /**
          * Show the application dashboard.
          *
          * @return \Illuminate\Http\Response
          */

         public functionTest all()
         {
             $user = Auth::user();

             if ($user) {

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

}
