<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\AuthResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\RegisResource;
use App\Http\Requests\RegisterRequest;

class ApiAuthController extends Controller
{
    //login
    public function login(LoginRequest $request)
    {
        // $validated = $request->validated();
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        //token lama terhapus
        $user->tokens()->delete();

        $token['token'] = $user->createToken('auth_token')->plainTextToken;

        // return response()->json([
        //     'message' => 'Hi ' . $user->name . ', welcome to home',
        //     'access_token' => $token,
        //     'token_type' => 'Bearer',
        // ]);
        $token = array_merge($user->toArray(), $token);

        //  dd($token);

        return new AuthResource($token);
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //  $token['token'] = $user->createToken('auth_token')->plainTextToken;
        $token = $user->createToken('auth_token')->plainTextToken;

        return new RegisResource([
            'user' => $user,
            'token' => $token,
        ]);

        // $token = array_merge($user->toArray(), $token);

        // return new AuthResource($token);
    }

    public function logout(Request $request)
    {
        $request
            ->user()
            ->tokens()
            ->delete();

        // return [
        //     'message' =>
        //         'You have successfully logged out and the token was successfully deleted',
        // ];

        return response()->noContent();
    }
}
