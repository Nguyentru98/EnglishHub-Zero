<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
class AuthController extends Controller
{
    public function Register(Request $request)
    {
        // validate
        request()->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|',
        ]);
        // tạo user
        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return response()->json([
            'message'=>'Tạo mới tài khoản thành công',
            'user' => $user->only(['id', 'full_name', 'email'])
        ],201);
    }

    public function login(Request $request) {
        $user = User::where('email',$request->email)->first();

        if(!$user || !Hash::check($request->password,$user->password)) {
            return response()->json([
                'message'=>'Thông tin đăng nhập không hợp lệ'
            ]);
        }

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'message' => 'Đăng nhập thành công',
            'token' => $token,
            'user' => $user->only(['id', 'full_name', 'email'])
        ]);
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Đã đăng xuất']);
    }

    public function list() {
        $listUser = User::all();
        return response()->json([
            'list' => $listUser
        ]);
    }
}
