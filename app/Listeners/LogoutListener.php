<?php

namespace App\Listeners;

// use App\Events\Logout;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Events\Logout;
use Cookie;

class LogoutListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        // ログアウト時に選択しているプランを削除する
        Cookie::queue(Cookie::make('selectPlan', null, 10000));
    }
}