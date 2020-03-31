<?php

namespace App\Http\Controllers;


use App\Models\TeacherComment;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class TeacherCommentController extends Controller
{
    //新增文章评论
    public function add(Request $request)
    {

        $user = JWTAuth::parseToken()->touser();//获取用户信息


        $articleComment = new TeacherComment;
        $articleComment['user_id'] = $user->id;
        $articleComment['teacher_id'] = $request['teacher_id'];
        $articleComment['content'] = $request['content'];
        $articleComment['level'] = $request['level'];
        $articleComment['parent_id'] = $request['parent_id'];
        if ($articleComment->save()) {

            return json_encode(
                [
                    'resultCode' => 0,
                    'resultMessage' => '新增教师评论成功',
                    'data' => []
                ]
            );
        }

        return json_encode(
            [
                'resultCode' => 1,
                'resultMessage' => '新增教师评论失败',
                'data' => []
            ]
        );
    }


    public function delete(Request $request)
    {

        $articleComment = ArticleComment::find($request['id']);
        if ($articleComment->delete()) {
            return json_encode(
                [
                    'resultCode' => 0,
                    'resultMessage' => '删除成功',
                    'data' => []
                ]
            );
        }

        return json_encode(
            [
                'resultCode' => 1,
                'resultMessage' => '删除失败',
                'data' => []
            ]
        );


    }
}
