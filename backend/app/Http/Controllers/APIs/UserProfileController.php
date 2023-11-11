<?php

namespace App\Http\Controllers\APIs;

use App\Models\Following;
use App\Models\Tweet;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserProfileController extends Controller
{
    public function info(Request $request): JsonResponse
    {
        $userID = $request->user()->id;
        $user = $request->user();
        $user->banner = asset('storage/static/img/login-cover.jpeg');
        $user->joined = $user->created_at->format('F, Y');
        $tweets = Tweet::query()
            ->with('creator:id,name,username,file_id')
            ->where('created_by', '=', $userID)
            ->orderBy('created_at', 'DESC')
            ->get();
        foreach ($tweets as $tweet) {
            $tweet->ago = getTimeAgo($tweet->created_at);
        }
        $following = Following::query()->where('follower_id', '=', $userID)->count();
        $follower = Following::query()->where('following_id', '=', $userID)->count();
        return response()->json([
            'user' => $user,
            'following' => $following,
            'follower' => $follower,
            'tweets' => $tweets,
            'status' => true
        ], 200);
    }
}
