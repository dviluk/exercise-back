<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\API;
use Auth;
use CurrentUser;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function test()
    {
        return API::response200();
    }

    public function me()
    {
        $user = CurrentUser::get();

        return API::response200([
            'data' => [
                'id' => (int) $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);
    }

    public function register(Request $request)
    {
        $attr = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $attr['name'],
            'password' => bcrypt($attr['password']),
            'email' => $attr['email']
        ]);

        return API::response200([
            'data' => [
                'token' => $user->createToken('API Token')->plainTextToken
            ]
        ]);
    }

    public function login(Request $request)
    {
        $attr = $request->validate([
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);

        if (!Auth::attempt($attr)) {
            return $this->error('Credentials not match', 401);
        }

        return API::response200([
            'data' => [
                'token' => CurrentUser::get()->createToken('API Token')->plainTextToken
            ]
        ]);
    }

    public function logout()
    {
        CurrentUser::get()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked'
        ];
    }
}
