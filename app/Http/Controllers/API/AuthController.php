<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    // public function register(Request $request)
    // {
    //     // validate the incoming request
    //     // set every field as required
    //     // set email field so it only accept the valid email format

    //     $this->validate($request, [
    //         'name' => 'required|string|min:2|max:255',
    //         'email' => 'required|string|email:rfc,dns|max:255|unique:users',
    //         'password' => 'required|string|min:6|max:255',
    //     ]);

    //     // if the request valid, create user

    //     $user = $this->user::create([
    //         'name' => $request['name'],
    //         'email' => $request['email'],
    //         'password' => bcrypt($request['password']),
    //     ]);

    //     // login the user immediately and generate the token
    //     $token = auth()->login($user);

    //     // return the response as json
    //     return response()->json([
    //         'meta' => [
    //             'code' => 200,
    //             'status' => 'success',
    //             'message' => 'User created successfully!',
    //         ],
    //         'data' => [
    //             'user' => $user,
    //             'access_token' => [
    //                 'token' => $token,
    //                 'type' => 'Bearer',
    //                 'expires_in' => auth()->factory()->getTTL() * 60,    // get token expires in seconds
    //             ],
    //         ],
    //     ]);
    // }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string  $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }
}
