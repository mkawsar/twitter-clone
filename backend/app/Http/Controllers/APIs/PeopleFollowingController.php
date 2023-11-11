<?php

namespace App\Http\Controllers\APIs;

use App\Models\Following;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PeopleFollowingController extends Controller
{
    public function getPeopleList(Request $request)
    {
        $followingArray = [];
        $followings = Following::query()->where('follower_id', '=', $request->user()->id)->select('following_id')->get();
        foreach ($followings as $key => $following) {
            $followingArray[$key] = $following->following_id;
        }

        array_push($followingArray, $request->user()->id);
        $peoples = User::query()->whereNotIn('id', $followingArray)->inRandomOrder()->limit(5)->get();
        return $peoples;
    }

    public function storeFollowing(Request $request, $userID): JsonResponse
    {
        $user = User::query()->find($userID);

        if (empty($user)) {
            return response()->json([
                'message' => 'User not found',
                'status' => false
            ], 404);
        }
        $following = new Following();
        $following->following_id = $userID;
        $following->follower_id = $request->user()->id;

        if ($following->save()) {
            return response()->json([
                'message' => 'Your following has been stored successfully',
                'status' => true
            ], 201);
        } else {
            return response()->json([
                'message' => 'Your following has not been stored successfully',
                'status' => false
            ], 412);
        }
    }
}
