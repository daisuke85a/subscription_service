<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Log;
use Cookie;
use Illuminate\Validation\Rule;
use Illuminate\Support\MessageBag;

class SubscriptionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * サブスクプリションプランを選択する
     * 未ログインの場合はCookieに格納する
     * @param Request $request
     * @return void
     */
    public function select(Request $request){

        $validatedData = $request->validate([
            'plan' => [
                'required',
                Rule::in([1000, 3000, 5000]),
            ],
        ]);



        // 未ログインの場合は一旦Cookieに保存する
        if (Auth::check() === false) {
            Log::info('未ログインでサブスクリプションプランを選択した。一旦Cookieに保存する selectPlan="' . print_r($request->plan, true) . '"');
            Cookie::queue(Cookie::make('selectPlan', $request->plan, 10000));
            return redirect('/register');
        }
        else{
            // ログイン中の場合はクレジットカード入力画面へ遷移する
            Log::info('ログイン中にサブスクリプションプランを選択した。 selectPlan="' . print_r($request->plan, true) . '"');
            return redirect('/credit');
        }
    }

    /**
     * クレジットカードの入力を行う
     *
     * @param Request $request
     * @return void
     */
    public function inputCredit(Request $request){

        // 未ログインの場合はクレジットカード入力を許可しない
        if (Auth::check() === false) {
            Log::warning('未ログインのためクレジットカード入力画面を開かない。');

            $messages = new MessageBag;
            $messages->add('', '未ログインのためクレジットカード入力はできません');

            return redirect('/')->withErrors($messages);
        }

        // 有効なプランが選択されていない場合は入力を許可しない。
        // TODO: ログアウトしたらキャッシュをクリアしたい。むしろPlan情報は本当はSessionに入れたい。
        // TODO: Sessionに入れていない理由は、ログインとともにセッション情報がクリア（IDがリジェネリトされる）される問題を
        // 解消するのが難しいから。
        $selectPlanCookie = (int)(Cookie::get('selectPlan'));

        if( ($selectPlanCookie !== 1000) &&
            ($selectPlanCookie !== 3000) &&
            ($selectPlanCookie !== 5000)
        ){
            Log::warning('課金プランが未選択のためクレジットカード入力はできません');

            $messages = new MessageBag;
            $messages->add('', '課金プランが未選択です');

            return redirect('/')->withErrors($messages);

        }

        // 課金中ユーザーの場合
        if(Auth::user()->status === 1){
            Log::warning('課金ユーザーはクレジットカード情報入力画面を開けない');

            $messages = new MessageBag;
            $messages->add('', '課金中ユーザーはクレジットカード入力はできません。');

            return redirect('/')->withErrors($messages);

        }

        return view('credit' , ['selectPlan' => $selectPlanCookie]);

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
            Log::warning('未ログインだから課金しない');
            return redirect('/');
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
            $selectPlan['plan'] = 'plan_FckQgGfrqyKrFb';
        }
        else{
            // Cokkieの値が無効値だった場合はサブスクリプションを開始しない
            Log::error('Cokkieの値が無効値だった場合はサブスクリプションを開始しない selectPlanCookie="' . print_r($selectPlanCookie, true) . '"');
            return redirect('/');
        }

        try{
            //Stripeにサブスクリプションプランの登録をする
            $sub = $user->newSubscription($selectPlan['name'], $selectPlan['plan'])->create($request->stripeToken);
        }catch(Exception $e){
            //TODO: ユーザーにエラーメッセージを表示したい
            Log::error('Stripeにサブスクリプションプランの登録を失敗しました');
            return redirect('/');
        }

        // ユーザー情報を更新する
        $user->plan = (int)$selectPlan['name'];
        $user->status = true;
        $user->update();

        Log::info('サブスクリプション課金を開始する user_id="' . print_r($user->id, true) . '" 課金プラン="' . print_r($user->plan, true) . '" ');

        return redirect('/');
    }

    /**
     * サブスクリプションの課金を停止する
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function unsubscribe(Request $request)
    {

        Log::info('SubsriptionController.unsubscribeがコールされた');

        // 未ログインの場合は処理しない
        if (Auth::check() === false) {
            Log::error('未ログインだから課金停止しない');
            return redirect('/');
        }

        // ログイン中のユーザーを取得する
        $user = Auth::user();

        // サブスクリプションのプランが想定外の場合はエラーとして終了する
        if( ($user->plan !== 1000) &&
            ($user->plan !== 3000) &&
            ($user->plan !== 5000)  ){
            Log::error('DBに記録されているサブスクプリションのプランが想定外です user_id="' . print_r($user->id, true) . '" 課金プラン="' . print_r($user->plan, true) . '" ');
            return redirect('/');
        }

        try{
            //サブスクプリションプランを退会する
            $user->subscription((string)$user->plan)->cancel();
        }catch(Exception $e){
            //TODO: ユーザーにエラーメッセージを表示したい
            Log::error('Stripeにサブスクリプションプランの退会に失敗しました');
            return redirect('/');
        }

        $user->status = false;
        $user->update();

        return redirect('/');

    }

    // TODO: サブスクリプション済みのユーザーの場合は、２重登録されないようガードする
    // TODO: キャッシュカード入力をさせない。
    // TODO: サブスクリプションの開始をさせない。





}
