<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class DashboardController extends Controller
{
    //
    public function index()
    {
        return json_encode(
            [
                'resultCode'    => 0,
                'resultMessage' => '请求看板数据成功',
                'data'          => [
                    'CurrentWeek'  => 5655,
                    'PreviousWeek' => 4356,
                    'actuals'      => [37, 83, 41, 67, 45, 71, 56, 58, 35, 80,
                                       39, 72],
                    'dataList'     => [
                        ['name' => '注册用户', 'value' => 13563, 'number' => 2.83],
                        ['name' => '未处理反馈', 'value' => 9563, 'number' => 4.61],
                        ['name' => '未处理报名', 'value' => 663, 'number' => 6.12],
                        ['name' => '今日访问', 'value' => 163, 'number' => 9.2],
                    ],
                    'doughnut'     => [38, 44, 44, 39],
                    'lineData'     => [
                        'Current'  => [41, 68, 70, 34, 60, 60, 74],
                        'Previous' => [49, 43, 61, 66, 37, 67, 41],
                    ],
                    'projections'  => [49, 41, 67, 71, 77, 31, 54, 63, 82, 72,
                                       52, 57],
                ]
            ]
        );
    }
}
