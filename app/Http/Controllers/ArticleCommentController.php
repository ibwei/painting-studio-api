<?php

namespace App\Http\Controllers;

use App\Models\ArticleComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class ArticleCommentController extends Controller
{

    //获取文章评论列表
    public function list(Request $request)
    {
        $pageSize = $request->pageSize;
        $pageNum  = $request->pageNum;


        $result = DB::table('article_comment')->join('users','article_comment.user_id','=','users.id')->join('article','article_comment.article_id','=','article.id')->select('users.name as username','article.title as title','article_comment.level as level','parent_id','article_comment.content','article_comment.id as id','article_comment.status as status','article_comment.created_at')->skip($pageSize * ($pageNum - 1))->take(
            $pageSize
        )->whereNull('article_comment.deleted_at')->orderBy('article_comment.created_at', 'desc')->orderBy(
            'article_comment.status', 'ase'
        )->get();

        $count = articleComment::all()->count();

        return json_encode(
            [
                'resultCode'    => 0,
                'resultMessage' => '获取文章评论列表成功',
                'data'          => $result,
                'total'         => $count,
            ]
        );
    }
    
    //新增文章评论
    public function add(Request $request)
    {

        $user = JWTAuth::parseToken()->touser();//获取用户信息

        if (!$user) {
            return json_encode(
                [
                    'resultCode' => 1,
                    'resultMessage' => '未登录',
                    'data' => []
                ]
            );
        }

        $articleComment = new ArticleComment;
        $articleComment['user_id'] = $user->id;
        $articleComment['article_id'] = $request['article_id'];
        $articleComment['content'] = $request['content'];
        $articleComment['level'] = $request['level'];
        $articleComment['parent_id'] = $request['parent_id'];
        if ($articleComment->save()) {

            return json_encode(
                [
                    'resultCode' => 0,
                    'resultMessage' => '新增文章评论成功',
                    'data' => []
                ]
            );
        }

        return json_encode(
            [
                'resultCode' => 1,
                'resultMessage' => '新增文章评论失败',
                'data' => []
            ]
        );
    }

    // 编辑教师详情
    public function update(Request $request)
    {
        $article = ArticleComment::find($request['id']);
        $article['status'] = $request['status'];

        if ($article->save()) {
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
