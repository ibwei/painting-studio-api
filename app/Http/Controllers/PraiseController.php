<?php

namespace App\Http\Controllers;

use App\Models\Praise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class PraiseController extends Controller
{
    //
    //获取点赞列表
    public function praiseList(Request $request)
    {
        $pageSize = $request->pageSize;
        $pageNum  = $request->pageNum;


        $result = DB::table('praise')->skip($pageSize * ($pageNum - 1))->take(
            $pageSize
        )->whereNull('deleted_at')->orderBy('created_at', 'desc')->orderBy(
            'status', 'ase'
        )->get();

        $count = praise::all()->count();

        return json_encode(
            [
                'resultCode'    => 0,
                'resultMessage' => '获取反馈列表成功',
                'data'          => $result,
                'total'         => $count,
            ]
        );
    }


    //新增点赞
    public function add(Request $request)
    {
        $praise          = new Praise;
        $praise['praise_time']    = $request['praise_time'];
        $praise['device']    = $request['device'];
        $praise['login_ip']    = $request->getClientIp();
        $praise->save();
        return json_encode(
            [
                'resultCode'    => 0,
                'resultMessage' => '点赞成功',
                'data'          => []
            ]
        );
    }


    //更新
    public function update(Request $request)
    {
        $user = JWTAuth::parseToken()->touser();//获取用户信息

        $praise = praise::find($request['id']);

        $this->email = $praise->email;

        $praise->result  = $request['result'];
        $praise->status  = 1;
        $praise->user_id = $user->id;

        if ($praise->save()) {

            if ($request->result != '' && $this->email != '') {
                try {
                    Mail::raw(
                        $praise->result, function ($message) {
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

    public function delete(Request $request)
    {

        $praise = praise::find($request['id']);
        if ($praise->delete()) {
            return json_encode(
                [
                    'resultCode'    => 0,
                    'resultMessage' => '删除点赞成功',
                    'data'          => []
                ]
            );
        }

        return json_encode(
            [
                'resultCode'    => 1,
                'resultMessage' => '删除点赞失败',
                'data'          => []
            ]
        );


    }
}
