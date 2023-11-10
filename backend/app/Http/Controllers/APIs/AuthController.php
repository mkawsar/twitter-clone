<?php

namespace App\Http\Controllers\APIs;

use App\Http\Requests\Authentication\LoginFormRequest;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginFormRequest $request)
    {
        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';


        // Find user in database
        $user = User::query()
            ->where('email', strtolower($request->username))
            ->orWhere('username', '=', strtolower($request->username))
            ->first();

        if (empty($user)) {
            return response()->json([
                'message' => 'User not found',
                'status' => false
            ], 404);
        }

        $credentials = [$fieldType => $request->username, 'password' => $request->password];

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token, $request->user());
        }

        return response()->json([
            'error' => 'Please check your provided email/username and password',
            'status' => false
        ], 401);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $user)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'expires_in' => $this->guard()->factory()->getTTL() * 60,
            'status' => true
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }

    public function me(Request $request)
    {
        return response()->json([
            'data' => $request->user(),
            'status' => true
        ], 200);
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out', 'status' => true], 200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request)
    {
        return $this->respondWithToken($this->guard()->refresh(), $request->user());
    }

}
