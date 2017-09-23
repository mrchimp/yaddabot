<?php

namespace App\Http\Controllers;

use Log;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use App\Conversations\ExampleConversation;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->hears('i like {thing}', 'App\Bot\Likes@selfLike');
        $botman->hears('i don\'t like {thing}', 'App\Bot\Likes@selfDislike');
        $botman->hears('{username} doesn\'t like {thing}', 'App\Bot\Likes@otherDislike');
        $botman->hears('who likes {thing}', 'App\Bot\Likes@whoLikes');
        $botman->hears('{username} likes {thing}', 'App\Bot\Likes@otherLike');
        $botman->hears('what does {username} like', 'App\Bot\Likes@personLikes');
        $botman->hears('what doesn\'t {username} like', 'App\Bot\Likes@personDislikes');
        $botman->hears('what do i like', 'App\Bot\Likes@selfWhatLike');
        $botman->hears('what don\'t i like', 'App\Bot\Likes@selfWhatDislike');

        $botman->listen();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tinker()
    {
        return view('tinker');
    }

    /**
     * Loaded through routes/botman.php
     * @param  BotMan $bot
     */
    public function startConversation(BotMan $bot)
    {
        $bot->startConversation(new ExampleConversation());
    }
}
