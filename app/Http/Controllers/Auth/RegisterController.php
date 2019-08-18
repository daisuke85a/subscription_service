<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Cookie;
use Log;
use Illuminate\Support\MessageBag;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected function redirectTo() 
    {
        $user = Auth::user();

        // roleによって、リダイレクト先を変える
        if ($user->role === 1) {
            return '/';
        } else {
            return '/credit';
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // id=1のユーザーがいるかの確認
        $users = User::where('id', 1)->count();

        // 登録ユーザーがいない場合
        // 管理者の登録として、role に 1 を入れる
        if ($users === 0) {
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'role' => 1,
            ]);
        } else {
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
        }
        
    }

    /**
     * ユーザー登録画面の表示
     *
     * @return void
     */
    public function showRegistrationForm(){
        
        $selectPlanCookie = (int)(Cookie::get('selectPlan'));
        
        if( ($selectPlanCookie !== 1000) &&
            ($selectPlanCookie !== 3000) &&
            ($selectPlanCookie !== 5000)
        ){
            Log::warning('課金プランが未選択のためユーザー登録画面は表示できません');

            $messages = new MessageBag;
            $messages->add('', '課金プランが未選択のためユーザー登録画面は表示できません');

            return redirect('/')->withErrors($messages);
        }

        return view('auth.register');
    }
}