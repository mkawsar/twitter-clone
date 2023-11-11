<?php

namespace App\Http\Controllers\APIs;

use App\Http\Requests\Profile\EditUserProfileFormRequest;
use App\Models\Following;
use App\Models\Tweet;
use App\Traits\FileUploadTrait;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserProfileController extends Controller
{
    use FileUploadTrait;
    public function info(Request $request): JsonResponse
    {
        $userID = $request->user()->id;
        $user = $request->user();
        $user->banner = asset('storage/static/img/login-cover.jpeg');
        $user->joined = $user->created_at->format('F, Y');
        $tweets = Tweet::query()
            ->with('creator:id,name,username,image')
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

    public function edit(EditUserProfileFormRequest $request)
    {
        $user = User::query()->find($request->user()->id);

        if (empty($user)) {
            return response()->json([
                'message' => 'User not found',
                'status' => false
            ], 404);
        }
        $fileName = $this->upload($request->file('image'), $request->user()->id);

        $payload = [
            'name' => $request->name,
            'image' => $fileName
        ];

        if ($user->update($payload)) {
            return response()->json([
                'message' => 'Your profile has been updated successfully',
                'user' => User::query()->find($request->user()->id),
                'status' => true
            ], 201);
        } else {
            return response()->json([
                'message' => 'Your profile has not been updated successfully',
                'status' => false
            ], 412);
        }
    }
}
