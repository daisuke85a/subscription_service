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

    

}
