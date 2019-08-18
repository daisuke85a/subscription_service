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

    public function testテスト用DB、未ログインで管理者であれば管理者登録画面へリダイレクトする() {

        // ユーザーを１つ作成
        // ここで作成するユーザーにはデフォルトでroleを 1 にしている
        $user = factory(User::class)->create([
            'password'  => bcrypt('test1111')
        ]);
 
        // まだ、認証されていない
        $this->assertFalse(Auth::check());
 
        // ログインを実行
        $response = $this->post('login', [
            'email'    => $user->email,
            'password' => 'test1111'
        ]);
 
        // 認証されている
        $this->assertTrue(Auth::check());
 
        $response->assertRedirect('/');

        // 管理画面への遷移を確認
        $this->get('/')
             ->assertSee('管理画面');

    }

}
