<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Mockery\Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Mail;
use Illuminate\Support\Facades\DB;


class FeedbackController extends Controller
{

    public $email = '';

    //获取反馈列表
    public function feedbackList(Request $request)
    {
        $pageSize = $request->pageSize;
        $pageNum  = $request->pageNum;


        $result = DB::table('feedback')->skip($pageSize * ($pageNum - 1))->take(
            $pageSize
        )->whereNull('deleted_at')->orderBy('created_at', 'desc')->orderBy(
            'status', 'ase'
        )->get();

        $count = Feedback::all()->count();

        return json_encode(
            [
                'resultCode'    => 0,
                'resultMessage' => '获取反馈列表成功',
                'data'          => $result,
                'total'         => $count,
            ]
        );
    }

    //新增反馈
    public function feedbackAdd(Request $request)
    {

        $feedback          = new Feedback;
        $feedback->name    = $request->name;
        $feedback->wechat  = $request->wechat;
        $feedback->phone   = $request->phone;
        $feedback->email   = $request->email;
        $feedback->content = $request['content'];

        $feedback->save();

        return json_encode(
            [
                'resultCode'    => 0,
                'resultMessage' => '新增成功',
                'data'          => []
            ]
        );
    }


    //更新
    public function feedbackUpdate(Request $request)
    {
        $user = JWTAuth::parseToken()->touser();//获取用户信息

        $feedback = Feedback::find($request['id']);

        $this->email = $feedback->email;

        $feedback->result  = $request['result'];
        $feedback->status  = 1;
        $feedback->user_id = $user->id;

        if ($feedback->save()) {

            if ($request->result != '' && $this->email != '') {
                try {
                    Mail::raw(
                        $feedback->result, function ($message) {
                        $message->from('997132391@qq.com', '品贤画室');
                        $message->subject('品贤画室反馈消息处理结果');
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

    public function feedbackDelete(Request $request)
    {

        $feedback = Feedback::find($request['id']);
        if ($feedback->delete()) {
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
