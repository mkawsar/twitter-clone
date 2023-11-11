<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    protected $table = 'tweets';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['uuid', 'tweet', 'like', 'created_by', 'updated_by'];
}
