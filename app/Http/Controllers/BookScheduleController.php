<?php

namespace App\Http\Controllers;

use App\Models\BookSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;

class BookScheduleController extends Controller
{
    public $email = '';

    public function list(Request $request)
    {
        try {
            $type = $request['type'];
            if ($type == 'day') {
                $result = DB::table('book_schedule')->join('users', 'book_schedule.user_id', '=', 'users.id')->join('schedule', 'book_schedule.schedule_id', '=', 'schedule.id')->select('book_schedule.schedule_id', 'email', 'phone', 'avatar', 'day', 'time', 'book_schedule.status', 'book_schedule.created_at', 'users.name')->whereDate('book_schedule.created_at', date("Y-m-d"))->whereNull('book_schedule.deleted_at')->orderBy('schedule.day')->orderBy('schedule.time')->get();
            } else if ($type == 'week') {
                $endLastWeek = Carbon::now()->subWeek(0)->startOfWeek();
                $result = DB::table('book_schedule')->join('users', 'book_schedule.user_id', '=', 'users.id')->join('schedule', 'book_schedule.schedule_id', '=', 'schedule.id')->select('book_schedule.schedule_id', 'email', 'phone', 'avatar', 'day', 'time', 'book_schedule.status', 'book_schedule.created_at', 'users.name')->whereNull('book_schedule.deleted_at')->where([['book_schedule.created_at', '>=', $endLastWeek],['book_schedule.status','=',1]])->orderBy('schedule.day')->orderBy('schedule.time')->get();
            } else {
                $pageSize = $request->pageSize;
                $pageNum = $request->pageNum;
                $result = DB::table('book_schedule')->join('users', 'book_schedule.user_id', '=', 'users.id')->join('schedule', 'book_schedule.schedule_id', '=', 'schedule.id')->select('book_schedule.id', 'book_schedule.schedule_id', 'email', 'phone', 'avatar', 'day', 'time', 'book_schedule.status', 'book_schedule.created_at', 'users.name')->skip($pageSize * ($pageNum - 1))->take(
                    $pageSize
                )->whereNull('book_schedule.deleted_at')->orderBy('book_schedule.created_at', 'desc')->orderBy(
                    'book_schedule.status'
                )->get();
                $count = BookSchedule::all()->count();
                return json_encode(
                    [
                        'resultCode' => 0,
                        'resultMessage' => '获取预约列表成功',
                        'data' => $result,
                        'total' => $count,
                    ]
                );
            }

            return json_encode(
                [
                    'resultCode' => 0,
                    'resultMessage' => '获取预约列表成功',
                    'data' => $result,
                ]
            );
        } catch (\Exception $e) {
            return json_encode(
                [
                    'resultCode' => 1,
                    'resultMessage' => $e,
                    'data' => [],
                ]
            );
        }
    }

    // 获取某个课程预约的详情
    public function detail(Request $request)
    {
        $id = $request['id'];
        $endLastWeek = Carbon::now()->subWeek(0)->startOfWeek();
        $result = DB::table('book_schedule')->join('users', 'book_schedule.user_id', '=', 'users.id')->select('users.name as name', 'users.avatar')->whereNull('book_schedule.deleted_at')->where([['book_schedule.created_at', '>=', $endLastWeek], ['book_schedule.schedule_id', '=', $id], ['book_schedule.status', '=', 1]])->get();
        if (count($result) > 0) {
            return json_encode(
                [
                    'resultCode' => 0,
                    'resultMessage' => '获取该节课程预约列表成功',
                    'data' => $result,
                ]
            );
        } else {
            return json_encode(
                [
                    'resultCode' => 1,
                    'resultMessage' => '获取该节课程无人预约',
                    'data' => [],
                ]
            );
        }

    }

    public function personalList()
    {
        $user = JWTAuth::parseToken()->touser();//获取用户信息
        $result = DB::table('schedule')->join('users', 'users.id', '=', 'user_id')->join('schedule', 'schedule.id', '=', 'schedule_id')->where('book_schedule.id', $user['id'])->whereNull('deleted_at')->whereRaw('YEARWEEK(date_format(created_at,"%Y-%m-%d") = YEARWEEK(now())')->orderBy('schedule.day')->orderBy(
            'schedule.time'
        )->get();
        return json_encode(
            [
                'resultCode' => 0,
                'resultMessage' => '获取个人预约列表成功',
                'data' => $result,
            ]
        );
    }


    // 增加预约
    public function add(Request $request)
    {

        $user = JWTAuth::parseToken()->touser();//获取用户信息

        $bookSchedule = new BookSchedule;
        $bookSchedule['user_id'] = $user->id;
        $bookSchedule['schedule_id'] = $request['schedule_id'];
        $bookSchedule['status'] = $request['status'];
        if ($bookSchedule->save()) {

            return json_encode(
                [
                    'resultCode' => 0,
                    'resultMessage' => '添加预约成功',
                    'data' => []
                ]
            );
        }

        return json_encode(
            [
                'resultCode' => 1,
                'resultMessage' => '添加预约失败',
                'data' => []
            ]
        );
    }

    //处理预约
    public function update(Request $request)
    {
        $bookSchedule = BookSchedule::find($request['id']);
        $bookSchedule['status'] = $request['status'];
        if ($bookSchedule->save()) {
            $week = [0 => '星期日', 1 => '星期一', 2 => '星期二', 3 => '星期三', 4 => '星期四', 5 => '星期五', 6 => '星期六'];
            $day = [0 => '上午', 1 => '下午', 2 => '晚上'];
            if ($request['email']) {
                $result = DB::table('book_schedule')->join('users', 'book_schedule.user_id', '=', 'users.id')->join('schedule', 'book_schedule.schedule_id', '=', 'schedule.id')->select('users.name as name', 'schedule.day', 'schedule.time')->whereNull('book_schedule.deleted_at')->where('book_schedule.id', '=', $request['id'])->get();
                $this->email = $request['email'];
                if ($request['status'] == 1) {
                    $content = '你好，' . $result[0]->name . '。对于你于本周' . $week[$result[0]->day] . $day[$result[0]->time] . '的课程预约请求，画室工作人员已经确认，请准按照约定时间来上课。';
                    Mail::raw(
                        $content, function ($message) {
                        $message->from('997132391@qq.com', '品贤画室');
                        $message->subject('品贤画室预约课程成功的通知');
                        $message->to($this->email);
                    });
                } else {
                    $content = '你好，' . $result[0]->name . '。对于你于本周' . $week[$result[0]->day] . $day[$result[0]->time] . '的课程预约请求，画室工作人员已经拒绝了该预约，拒绝原因会通过电话联系你。对你造成了不便，敬请谅解！';
                    Mail::raw(
                        $content, function ($message) {
                        $message->from('997132391@qq.com', '品贤画室');
                        $message->subject('品贤画室预约课程失败的通知');
                        $message->to($this->email);
                    });

                }
            }

            return json_encode(
                [
                    'resultCode' => 0,
                    'resultMessage' => '预约处理成功',
                    'data' => []
                ]
            );

        }
        return json_encode(
            [
                'resultCode' => 1,
                'resultMessage' => '预约处理失败',
                'data' => []
            ]
        );
    }

    //处理预约
    public
    function delete(Request $request)
    {

        $bookSchedule = BookSchedule::find($request['id']);
        if ($bookSchedule->delete()) {
            return json_encode(
                [
                    'resultCode' => 0,
                    'resultMessage' => '预约删除成功',
                    'data' => []
                ]
            );

        }
        return json_encode(
            [
                'resultCode' => 1,
                'resultMessage' => '预约删除失败',
                'data' => []
            ]
        );
    }
}
