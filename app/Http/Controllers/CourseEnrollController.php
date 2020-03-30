<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseEnroll;
use Tymon\JWTAuth\Facades\JWTAuth;
use Mail;
use Illuminate\Support\Facades\DB;

class CourseEnrollController extends Controller
{
    //获取反馈列表
    public function courseEnrollList(Request $request)
    {
        $pageSize = $request->pageSize;
        $pageNum  = $request->pageNum;

        $result = DB::table('course_enroll')->skip($pageSize * ($pageNum - 1))
            ->take(
                $pageSize
            )->whereNull('deleted_at')->orderBy('created_at', 'desc')->orderBy(
            'status', 'ase'
        )->get();

        $count = courseEnroll::all()->count();

        return json_encode(
            [
                'resultCode'    => 0,
                'resultMessage' => '获取课程报名列表成功',
                'data'          => $result,
                'total'         => $count,
            ]
        );
    }

    //新增反馈
    public function courseEnrollAdd(Request $request)
    {
        $courseEnroll                = new courseEnroll;
        $courseEnroll->name          = $request->name;
        $courseEnroll->wechat        = $request->wechat;
        $courseEnroll->phone         = $request->phone;
        $courseEnroll->email         = $request->email;
        $courseEnroll['user_id']     = $request['user_id'];
        $courseEnroll['course_name'] = $request['course_name'];
        $courseEnroll['course_id']   = $request['course_id'];

        $courseEnroll->save();

        return json_encode(
            [
                'resultCode'    => 0,
                'resultMessage' => '新增成功',
                'data'          => []
            ]
        );
    }


    //更新
    public function courseEnrollUpdate(Request $request)
    {
        $user = JWTAuth::parseToken()->touser();//获取用户信息

        $courseEnroll = courseEnroll::find($request['id']);

        $this->email = $courseEnroll->email;

        $courseEnroll->result  = $request['result'];
        $courseEnroll->status  = 1;
        $courseEnroll->user_id = $user->id;

        if ($courseEnroll->save()) {

            if ($request->result != '' && $this->email != '') {
                try {
                    Mail::raw(
                        $courseEnroll->result, function ($message) {
                        $message->from('997132391@qq.com', '品贤画室');
                        $message->subject('品贤画室在线报名处理结果');
                        $message->to($this->email);
                    }
                    );
                } catch (Exception $e) {
                    return json_encode(
                        [
                            'resultCode'    => 0,
                            'resultMessage' => '保存成功,但是发送邮件给用户失败了。',
                            'data'          => []
                        ]
                    );
                };
            }

            return json_encode(
                [
                    'resultCode'    => 0,
                    'resultMessage' => '回复成功',
                    'data'          => []
                ]
            );
        }

        return json_encode(
            [
                'resultCode'    => 1,
                'resultMessage' => '回复失败',
                'data'          => []
            ]
        );
    }

    public function courseEnrollDelete(Request $request)
    {

        $courseEnroll = courseEnroll::find($request['id']);
        if ($courseEnroll->delete()) {
            return json_encode(
                [
                    'resultCode'    => 0,
                    'resultMessage' => '删除成功',
                    'data'          => []
                ]
            );
        }

        return json_encode(
            [
                'resultCode'    => 1,
                'resultMessage' => '删除失败',
                'data'          => []
            ]
        );


    }
}
