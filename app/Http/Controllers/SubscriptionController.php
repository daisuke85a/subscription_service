<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Log;
use Cookie;

class SubscriptionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * サブスクプリションプランを選択する
     * 未ログインの場合はCookieに格納する
     * @param Request $request
     * @return void
     */
    public function select(Request $request){

        // TODO: バリデーションを実装する

        // 未ログインの場合は一旦Cokkieに保存する
        if (Auth::check() === false) {
            Cookie::queue(Cookie::make('selectPlan', $request->plan, 10000));
            Log::info('未ログインでサブスクリプションプランを選択したため一旦Cokkieに保存する selectPlan="' . print_r($request->plan, true) . '"');                    
            return redirect('/register');
        }
        else{
            // ログイン中の場合は無視する
            // TODO: 退会後の再入会の時を考慮すると、ここで課金開始するのもありかも。
            Log::info('ログイン中にサブスクリプションプランを選択したため無視する selectPlan="' . print_r($request->plan, true) . '"');                    
        }
    }

    /**
     * サブスクリプションの課金を開始する
     * Cookieの値から判断する
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Request $request)
    {

        Log::info('SubsriptionController.createがコールされた');                    

        // 未ログインの場合は課金開始しない
        if (Auth::check() === false) {
            Log::error('未ログインだから課金しない');                    
            return false;
        }

        // ログイン中のユーザーを取得する
        $user = Auth::user();

        // Cokkieから選択中のプランを読み取り判断する
        $selectPlanCookie = (int)(Cookie::get('selectPlan'));
        $selectPlan = [];

        if($selectPlanCookie === 1000){
            $selectPlan['name'] = '1000';
            $selectPlan['plan'] = 'plan_FcTvnzhh0xY6Yd';
        }
        else if($selectPlanCookie === 3000){
            $selectPlan['name'] = '3000';
            $selectPlan['plan'] = 'plan_FckP9bTBJEccw2';
        }
        else if($selectPlanCookie === 5000){
            $selectPlan['name'] = '5000';
            $selectPlan['plan'] = 'prod_FcTuCIhPye6QGE';
        }
        else{
            // Cokkieの値が無効値だった場合はサブスクリプションを開始しない
            Log::error('Cokkieの値が無効値だった場合はサブスクリプションを開始しない'); 
            Log::error('Cokkieの値が無効値だった場合はサブスクリプションを開始しない selectPlanCookie="' . print_r($selectPlanCookie, true) . '"');                    
            return view('home');
        }

        try{
            //Stripeにサブスクリプションプランの登録をする
            $sub = $user->newSubscription($selectPlan['name'], $selectPlan['plan'])->create($request->stripeToken);
        }catch(Exception $e){
            Log::error('Stripeにサブスクリプションプランの登録を失敗しました');                    
            return;
        }
        
        // ユーザー情報を更新する
        $user->plan = (int)$selectPlan['name'];
        $user->status = true;
        $user->update();

        Log::info('サブスクリプション課金を開始する user_id="' . print_r($user->id, true) . '"');                    

        return view('home');
    }
}