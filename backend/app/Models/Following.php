<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Following extends Model
{
    protected $table = 'followings';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['following_id', 'follower_id'];
}
