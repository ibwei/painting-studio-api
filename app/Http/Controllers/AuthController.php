<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    /**
     * jwt 测试
     */

    //登录
    public function login(Request $request)
    {

        $username = $request->username;
        $password = $request->password;
        $user_mes = User::where('name', '=', $username)->first();

        if ( ! $user_mes || $password != $user_mes->password) {
            return json_encode(
                [
                    'resultCode' => 1,
                    'resultMessage'  => '账号或密码错误',
                ]
            );
        }

        $token = JWTAuth::fromUser($user_mes);//生成token
        if ( ! $token) {
            return json_encode(
                [
                    'resultCode' => 1,
                    'resultMessage'  => '登录失败,请重试',
                ]
            );
        }

        return json_encode(
            [
                'resultCode' => 0,
                'resultMessage'  => '登录成功',
                'data'     => [
                    'token' => $token,
                ]
            ]
        );

    }

    //获取用户信息
    public function  getUserInfo()
    {
        $user = JWTAuth::parseToken()->touser();//获取用户信息

        return json_encode(
            [
                'resultCode' => 0,
                'resultMessage'  => '获取成功',
                'data'     => [
                    'user' => $user,
                    'permissions'=>['1','2','3','4','5','6','7','8'],

                ]
            ]
        );

    }

    //退出
    public function logout()
    {
        JWTAuth::parseToken()->invalidate();//退出

        return json_encode(
            [
                'resultCode' => 0,
                'resultMessage'  => '退出成功 ',
            ]
        );
    }
}
