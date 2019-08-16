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
    public function index()
    {
        return view('home');
    }

    // TODO: HomeControllerを実装したら削除
    /**
     * Show the admin screen.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_admin_screen()
    {
        // ログイン中のユーザーを確認
        $user = Auth::user();

        // 管理者の場合のみ、管理画面に遷移できる
        if ($user->role === 1) {
            $users = User::all();
            return view('admin')->with('users', $users);
        } else {
            return redirect('/');
        }
    }
    
    //TODO(だん)：ルートパースの判断
    public function all()
    {
        $user = Auth::user();

        if ($user) {
            // 実際にカードを入力時にcard_brandカラムの値が入るので、
            //card_brandカラムの値有無でカードを登録しているかどうかを判断
            $card = $user->card_brand;

            if (!$card) {
              return view('credit');
            } else {
              // 一般ユーザーの時nomalページがないので、homeにしました
              return view('home');
            }
        } else {
            return view('select');
        }
    }

}
