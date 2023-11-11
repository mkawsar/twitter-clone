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

    public function storeFollowing(Request $request, $userID)
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

    public function getFollowingList(Request $request)
    {
        $people = Following::query()
            ->with('following:id,name,username,image')
            ->where('follower_id', '=', $request->user()->id)
            ->inRandomOrder()
            ->limit(5)
            ->get();
        return $people;
    }

    public function updateUnFollowing(Request $request, $followingID): JsonResponse
    {
        $following = Following::query()->find($followingID);

        if (empty($following)) {
            return response()->json([
                'message' => 'Data not found',
                'status' => false
            ], 404);
        }

        if ($following->delete()) {
            return response()->json([
                'message' => 'Your unfollow has been stored successfully',
                'status' => true
            ], 200);
        } else {
            return response()->json([
                'message' => 'Your unfollow has not been stored successfully',
                'status' => false
            ], 412);
        }
    }
}
