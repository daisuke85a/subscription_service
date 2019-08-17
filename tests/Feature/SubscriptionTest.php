<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriptionTest extends TestCase
{

    public function test未ログインでプラン選択したらユーザー登録画面へリダイレクトする(){
        $response = $this->post('/select',['plan' => '1000']);
        
        $response->assertStatus(302);
        $response->assertRedirect('/register');
    }

    public function test全てのサブスクリプションプランが選択できる(){

        $response = $this->post('/select', ['plan' => '1000']);        
        $response->assertCookie('selectPlan', '1000');

        $response = $this->post('/select', ['plan' => '3000']);
        $response->assertCookie('selectPlan', '3000');

        $response = $this->post('/select', ['plan' => '5000']);
        $response->assertCookie('selectPlan', '5000');

    }

    public function test不正なサブスクリプションが選択できない(){

        $response = $this->post('/select', ['plan' => '6000']);
        
        $response->assertCookieMissing('selectPlan');
    }

}