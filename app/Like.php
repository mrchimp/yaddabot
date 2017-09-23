<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes_dislikes';
    
    protected $fillable = [
        'username',
        'thing',
        'likingness',
    ];

    public static function add($username, $thing, $likingness)
    {
        $like = Like::where([
            'username' => $username,
            'thing' => $thing,
        ])->first();

        if ($like) {
            $like->update([
                'likingness' => $likingness,
            ]);
        } else {
            Like::create([
                'username' => $username,
                'thing' => $thing,
                'likingness' => $likingness,
            ]);
        }
    }
}
