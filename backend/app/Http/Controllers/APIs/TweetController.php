<?php

namespace App\Http\Controllers\APIs;

use App\Http\Requests\Tweet\CreateTweetFormRequest;
use App\Models\Tweet;
use App\Models\TweetLike;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TweetController extends Controller
{
    public function list(Request $request)
    {
        $tweets = Tweet::query()->orderBy('created_at', 'DESC')->simplePaginate(10);
        foreach ($tweets as $key => $item) {
            $check = TweetLike::query()->where('tweet_id', '=', $item->id)->where('liked_by', '=', $request->user()->id)->count();
            $item->ago = getTimeAgo($item->created_at);
            $item->liked = $check > 0 ? true : false;
        }

        return $tweets;
    }
    public function store(CreateTweetFormRequest $request): JsonResponse
    {
        $tweet = new Tweet();
        $tweet->uuid = uniqid();
        $tweet->tweet = $request->tweet;
        $tweet->created_by = $request->user()->id;
        $tweet->updated_by = $request->user()->id;

        if ($tweet->save()) {
            return response()->json([
                'message' => 'Your tweet has been created successfully',
                'status' => true
            ], 201);
        } else {
            return response()->json([
                'message' => 'Your tweet has not been created successfully',
                'status' => false
            ], 412);
        }
    }

    public function like(Request $request, $uuid): JsonResponse
    {
        $tweet = Tweet::query()->where('uuid', '=', $uuid)->first();
        if (empty($tweet)) {
            return response()->json([
                'message' => 'Data not found',
                'status' => false
            ], 404);
        }

        $check = TweetLike::query()->where('tweet_id', '=', $tweet->id)->where('liked_by', '=', $request->user()->id)->count();
        if ($check > 0) {
            return response()->json([
                'message' => 'Your tweet has been liked successfully',
                'status' => true
            ], 201);
        }

        $payload = [
            'like' => $tweet->like + 1
        ];

        if ($tweet->update($payload)) {
            $like = new TweetLike();
            $like->tweet_id = $tweet->id;
            $like->liked_by = $request->user()->id;
            $like->created_by = $request->user()->id;
            $like->save();
            return response()->json([
                'message' => 'Your tweet has been liked successfully',
                'status' => true
            ], 201);
        } else {
            return response()->json([
                'message' => 'Your tweet has not been liked successfully',
                'status' => false
            ], 412);
        }
    }
}
