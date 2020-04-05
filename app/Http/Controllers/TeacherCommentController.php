<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\TeacherComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class TeacherCommentController extends Controller
{


    //获取教师评论列表
    public function list(Request $request)
    {
        $pageSize = $request->pageSize;
        $pageNum  = $request->pageNum;


        $result = DB::table('teacher_comment')->join('users','teacher_comment.user_id','=','users.id')->join('teacher','teacher_comment.teacher_id','=','teacher.id')->select('users.name as username','teacher.name as teachername','teacher_comment.star as star','content','teacher_comment.id as id','teacher_comment.status as status','teacher_comment.created_at')->skip($pageSize * ($pageNum - 1))->take(
            $pageSize
        )->whereNull('teacher_comment.deleted_at')->orderBy('teacher_comment.created_at', 'desc')->orderBy(
            'teacher_comment.status', 'ase'
        )->get();

        $count = TeacherComment::all()->count();

        return json_encode(
            [
                'resultCode'    => 0,
                'resultMessage' => '获取教师评论列表成功',
                'data'          => $result,
                'total'         => $count,
            ]
        );
    }

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

    // 编辑教师详情
    public function update(Request $request)
    {
        $teacher = TeacherComment::find($request['id']);
        $teacher['status'] = $request['status'];

        if ($teacher->save()) {
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
                'resultCode' => 0,
                'resultMessage' => '处理失败',
                'data' => []
            ]
        );
    }


    public function delete(Request $request)
    {

        $articleComment = TeacherComment::find($request['id']);
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
