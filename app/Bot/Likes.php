<?php

namespace App\Bot;

use App\Like;

class Likes
{
    protected function removeTrailingQuestionMark($word)
    {
        if (substr($word, -1) === '?') {
            $word = substr($word, 0, -1);
        }
        
        return $word;
    }
    
    public function selfLike($bot, $thing)
    {        
        $username = $bot->getUser()->getUsername() ?: 'guest';
        Like::add($username, $thing, 3);
        $bot->reply('Yaddabot will remember that.');
    }

    public function otherLike($bot, $username, $thing)
    {
        if ($username === 'who') {
            return false;
        }
        Like::add($username, $thing, 3);
        $bot->reply('Yaddabot will remember that.');
    }
    
    public function selfDislike($bot, $thing)
    {        
        $username = $bot->getUser()->getUsername() ?: 'guest';
        Like::add($username, $thing, -3);
        $bot->reply('Yaddabot will remember that.');
    }

    public function otherDislike($bot, $username, $thing)
    {
        Like::add($username, $thing, -3);
        $bot->reply('Yaddabot will remember that.');
    }

    public function whoLikes($bot, $thing)
    {
        $thing = $this->removeTrailingQuestionMark($thing);
        $like = Like::where('thing', $thing)
            ->where('likingness', '>', 0)
            ->inRandomOrder()
            ->first();

        if ($like) {
            $bot->reply("$like->username likes $thing.");
        } else {
            $bot->reply('I dont know.');
        }
    }

    public function personLikes($bot, $username)
    {
        $like = Like::where('username', $username)
            ->where('likingness', '>', 0)
            ->orderByRaw('RAND()')
            ->first();

        if ($like) {
            $bot->reply("$username likes $like->thing.");
        } else {
            $bot->reply('I dont know.');
        }
    }
    
    public function personDislikes($bot, $username)
    {
        $like = Like::where('username', $username)
            ->where('likingness', '<', 0)
            ->orderByRaw('RAND()')
            ->first();

        if ($like) {
            $bot->reply("$username doesn't like $like->thing.");
        } else {
            $bot->reply('I dont know.');
        }
    }

    public function selfWhatDislike($bot)
    {
        $username = $bot->getUser()->getUsername() ?: 'guest';
        $like = Like::where('username', $username)
            ->where('likingness', '<', 0)
            ->orderByRaw('RAND()')
            ->first();

        if ($like) {
            $bot->reply("You don't like $like->thing.");
        } else {
            $bot->reply('I dont know.');
        }
    }

    public function selfWhatLike($bot)
    {
        $username = $bot->getUser()->getUsername() ?: 'guest';
        $like = Like::where('username', $username)
            ->where('likingness', '>', 0)
            ->orderByRaw('RAND()')
            ->first();

        if ($like) {
            $bot->reply("You like $like->thing.");
        } else {
            $bot->reply('I dont know.');
        }
    }
}