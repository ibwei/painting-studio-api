<?php

namespace App\Http\Controllers;

use App\Models\Statistics;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{

    //登录统计
    public function login(Request $request)
    {
        $praise = new Statistics;
        $praise['login_time'] = $request['login_time'];
        $praise['device'] = $request['device'];
        $praise['login_ip'] = $request->getClientIp();
        if ($praise->save()) {
            return json_encode(
                [
                    'resultCode' => 0,
                    'resultMessage' => '登录统计成功',
                    'data' => $praise->id,
                ]
            );
        } else {
            return json_encode(
                [
                    'resultCode' => 1,
                    'resultMessage' => '登录统计失败',
                ]
            );
        }
    }

    //退出统计
    public function logout(Request $request)
    {
        $praise = Statistics::find($request->id);

        $praise['logout_time'] = $request['logout_time'];
        $praise->save();
        return json_encode(
            [
                'resultCode' => 0,
                'resultMessage' => '退出统计成功',
                'data' => []
            ]
        );
    }
}
