<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class ScheduleController extends Controller
{
    public function list()
    {


        $result = DB::table('schedule')->whereNull('deleted_at')->orderBy('day')->orderBy(
            'time'
        )->get();

        return json_encode(
            [
                'resultCode' => 0,
                'resultMessage' => '获取日程列表成功',
                'data' => $result,
            ]
        );
    }

    //新增日程
    public function add(Request $request)
    {

        $schedule = new Schedule;
        $schedule['day'] = $request['day'];
        $schedule['time'] = $request['time'];
        $schedule['status'] = $request['status'];

        $result = DB::table('schedule')->whereNull('deleted_at')->where([['day', '=', $request['day']], ['time', '=', $request['time']]])->get();
        if (count($result) > 0) {
            return json_encode(
                [
                    'resultCode' => 1,
                    'resultMessage' => '该天该时段已有安排，只能编辑，不能新增',
                    'data' => []
                ]
            );
        }
        if ($schedule->save()) {

            return json_encode(
                [
                    'resultCode' => 0,
                    'resultMessage' => '新增日程成功',
                    'data' => []
                ]
            );
        }

        return json_encode(
            [
                'resultCode' => 1,
                'resultMessage' => '新增日程失败',
                'data' => []
            ]
        );
    }

    public function update(Request $request)
    {

        $schedule = schedule::find($request['id']);
        $schedule['day'] = $request['day'];
        $schedule['time'] = $request['time'];
        $schedule['status'] = $request['status'];
        if ($schedule->save()) {

            return json_encode(
                [
                    'resultCode' => 0,
                    'resultMessage' => '更新日程成功',
                    'data' => []
                ]
            );
        }

        return json_encode(
            [
                'resultCode' => 1,
                'resultMessage' => '更新日程失败',
                'data' => []
            ]
        );
    }

    public function delete(Request $request)
    {

        $schedule = schedule::find($request['id']);

        if ($schedule->delete()) {

            return json_encode(
                [
                    'resultCode' => 0,
                    'resultMessage' => '删除日程成功',
                    'data' => []
                ]
            );
        }

        return json_encode(
            [
                'resultCode' => 1,
                'resultMessage' => '删除日程失败',
                'data' => []
            ]
        );
    }

}
