<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TweetLike extends Model
{
    protected $table = 'tweet_likes';
    public $incrementing = true;
    public $timestamps = true;
}
