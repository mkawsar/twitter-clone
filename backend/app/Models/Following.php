<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Following extends Model
{
    protected $table = 'followings';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['following_id', 'follower_id'];

    public function following()
    {
        return $this->hasOne(User::class, 'id', 'following_id');
    }
}
