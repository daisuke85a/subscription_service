<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Illuminate\Support\Facades\Auth;

class AdminTest extends TestCase
{

    public function test未ログインで最初の登録者であれば管理者登録画面へリダイレクトする(){

        $user = User::where('id', 1)->count();
        if ($user == 0) {
            $response = $this->get('/');
            $response->assertSee('Admin');
        } else {
            $response = $this->get('/');
            $response->assertSee('PLAN');
        }

    }

    public function testログイン後、管理者なら管理画面へ遷移(){

        // id=1 に登録されているユーザーを取り出す
        $user = User::where('id', 1)->first();

        // ログインを実行
        $response = $this->post('/login', [
            'email'    => $user['email'],
            // パスワードを入れる(これは僕の場合)
            'password' => '11111111'
        ]);
 
        // 認証されている
        $this->assertTrue(Auth::check());

        // リダイレクト先が '/'
        $response->assertRedirect('/');
        
        // ログイン後に管理画面にリダイレクトされるのを確認
        $this->get('/')
             ->assertSee('管理画面');
    }

}
