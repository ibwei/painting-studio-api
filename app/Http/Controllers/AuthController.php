<?php

namespace App\Http\Controllers;


use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    /**
     * jwt 测试
     */

    public function list(Request $request)
    {
        $pageSize = $request->pageSize;
        $pageNum = $request->pageNum;


        $result = DB::table('users')->skip($pageSize * ($pageNum - 1))->take(
            $pageSize
        )->whereNull('deleted_at')->orderBy('created_at', 'desc')->orderBy(
            'updated_at', 'ase'
        )->get();

        $count = Users::all()->count();


        return json_encode(
            [
                'resultCode' => 0,
                'resultMessage' => '获取用户列表成功',
                'data' => $result,
                'total' => $count,
            ]
        );
    }

    //登录
    public function login(Request $request)
    {

        $username = $request->username;
        $password = $request->password;
        $user_mes = Users::where([['name', '=', $username], ['status', '=', 1]])->first();
        if (isset($request['type'])) {
            $type = $request['type'];
        } else {
            $type = 1;
        }
        if ($type == 1 && $user_mes['is_admin'] != 1) {
            return json_encode(
                [
                    'resultCode' => 1,
                    'resultMessage' => '账号或密码错误',
                ]
            );
        }
        if ($type == 0 && $user_mes['is_admin'] != 0) {
            return json_encode(
                [
                    'resultCode' => 1,
                    'resultMessage' => '账号或密码错误',
                ]
            );
        }

        if (!$user_mes || md5($password) != $user_mes->password) {
            return json_encode(
                [
                    'resultCode' => 1,
                    'resultMessage' => '账号或密码错误',
                ]
            );
        }

        $token = JWTAuth::fromUser($user_mes);//生成token
        if (!$token) {
            return json_encode(
                [
                    'resultCode' => 1,
                    'resultMessage' => '登录失败,请重试',
                ]
            );
        }

        $user_mes->login_time = date("Y-m-d H:i:s");
        $user_mes->save();
        return json_encode(
            [
                'resultCode' => 0,
                'resultMessage' => '登录成功',
                'data' => [
                    'token' => $token,
                    'user' => $user_mes
                ]
            ]
        );


    }

    //获取用户信息
    public function getUserInfo()
    {
        $user = JWTAuth::parseToken()->touser();//获取用户信息

        return json_encode(
            [
                'resultCode' => 0,
                'resultMessage' => '获取成功',
                'data' => [
                    'user' => $user,
                    'permissions' => ['1', '2', '3', '4', '5', '6', '7', '8'],

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
                'resultMessage' => '退出成功 ',
            ]
        );
    }

    //注册
    public function register(Request $request)
    {
        if (!isset($request->username) || !isset($request->password)) {
            return json_encode(
                [
                    'resultCode' => 1,
                    'resultMessage' => '注册失败,缺乏必要参数',
                ]
            );
        }

        $user_mes = Users::where('name', '=', $request->username)->first();
        if ($user_mes) {
            return json_encode(
                [
                    'resultCode' => 1,
                    'resultMessage' => '昵称重复，请重新选取名字',
                ]
            );
        }

        $user = new Users;
        $user->name = $request['username'];
        $user->password = md5($request->password);
        $user->email = isset($request->email) ? '' : $request->email;
        $user->phone = isset($request->phone) ? '' : $request->phone;
        $user->avatar = 'http://img.pinxianhs.com/timg.jpeg';
        $user->is_admin = $request['type'];
        if ($user->save()) {
            return $this->login($request);

        }
        return json_encode(
            [
                'resultCode' => 1,
                'resultMessage' => '注册失败，请检查输入字段',
                'data' => []
            ]
        );

    }

    public function update(Request $request)
    {
        $user = Users::find($request['id']);
        $user->status = $request['status'];
        $user->is_admin = $request['is_admin'];
        if ($user->save()) {
            return json_encode(
                [
                    'resultCode' => 0,
                    'resultMessage' => '处理成功',
                    'data' => []
                ]
            );
        }

        return json_encode(
            [
                'resultCode' => 1,
                'resultMessage' => '处理失败',
                'data' => []
            ]
        );

    }

    public function delete(Request $request)
    {

        $user = Users::find($request['id']);
        if ($user->delete()) {
            return json_encode(
                [
                    'resultCode' => 0,
                    'resultMessage' => '用户删除成功',
                    'data' => []
                ]
            );
        }

        return json_encode(
            [
                'resultCode' => 1,
                'resultMessage' => '用户删除失败',
                'data' => []
            ]
        );

    }
}
