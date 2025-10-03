<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

use function App\Utilities\json;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        try {
            if (!$token = JWTAuth::attempt($validated)) {
                return json(['error' => 'invalid credentials'], 'failed', 401);
            }
        } catch (JWTException $e) {
            return json(['error' => 'Falied to create Token'], 'failed', 500);
        }

        return json([
            'token' => $token,
            'expires in' => config('jwt.ttl') * 60 . " min"
        ], 'login successfull');
    }

    public function register(UserRegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password']
        ]);

        try {
            $token = JWTAuth::fromUser($user);
        } catch (JWTException $e) {

            return json(['error' => 'Falied to create Token'], 'failed', 500);
        }

        return json([
            'user' => $user,
            'token' => $token
        ], 'register succssfull', 201);
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (JWTException $e) {
            return json(['error' => 'Failed to logout, please try again'], 'failed', 500);
        }

        return json(['message' => 'Successfully logged out']);
    }
}
