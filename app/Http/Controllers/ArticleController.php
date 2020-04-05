<?php

namespace App\Http\Controllers;

use Hamcrest\Core\IsNull;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Article;
use Tymon\JWTAuth\Facades\JWTAuth;

class ArticleController extends Controller
{

    public function articleList(Request $request)
    {
        $pageSize = $request->pageSize;
        $pageNum = $request->pageNum;


        $result = DB::table('article')->skip($pageSize * ($pageNum - 1))->take(
            $pageSize
        )->whereNull('deleted_at')->orderBy('updated_at', 'desc')->orderBy(
            'created_at', 'ase'
        )->get();

        $count = Article::all()->count();


        return json_encode(
            [
                'resultCode' => 0,
                'resultMessage' => '获取文章列表成功',
                'data' => $result,
                'total' => $count,
            ]
        );
    }

    //新增文章
    public function articleAdd(Request $request)
    {

        $user = JWTAuth::parseToken()->touser();//获取用户信息

        $article = new Article;
        $article['user_id'] = $user->id;
        $article['title'] = $request['title'];
        $article['content'] = $request['content'];
        $article['tags'] = $request['tags'];
        $article['category'] = $request['category'];
        $article['thumbnail'] = $request['thumbnail'];

        if ($article->save()) {

            return json_encode(
                [
                    'resultCode' => 0,
                    'resultMessage' => '新增文章成功',
                    'data' => []
                ]
            );
        }

        return json_encode(
            [
                'resultCode' => 1,
                'resultMessage' => '新增文章失败',
                'data' => []
            ]
        );
    }


    //更新
    public function articleUpdate(Request $request)
    {

        $article = article::find($request['id']);

        $article['title'] = $request['title'];
        $article['content'] = $request['content'];
        $article['tags'] = $request['tags'];
        $article['category'] = $request['category'];
        $article['thumbnail'] = $request['thumbnail'];

        if ($article->save()) {


            return json_encode(
                [
                    'resultCode' => 0,
                    'resultMessage' => '文章更新成功',
                    'data' => []
                ]
            );

        }

        return json_encode(
            [
                'resultCode' => 1,
                'resultMessage' => '文章更新失败',
                'data' => []
            ]
        );
    }


    public function articleDelete(Request $request)
    {

        $article = article::find($request['id']);
        if ($article->delete()) {
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

    //前端页面所需要的参数

    public function articleListByCategory(Request $request)
    {

        try {
            $pageNum = $request->pageNum;
            $pageSize = $request->pageSize;
            $categroy = $request->category;

            $result = DB::table('article')->skip($pageSize * ($pageNum - 1))
                ->take(
                    $pageSize
                )->where('category', '=', $categroy)->whereNull('deleted_at')
                ->orderBy(
                    'created_at', 'desc'
                )->get()->groupBy('category');

            $count = Article::all()->count();

            return json_encode(
                [
                    'resultCode' => 0,
                    'resultMessage' => '获取文章列表成功',
                    'data' => $result,
                    'total' => $count,
                ]
            );
        } catch (Exception $e) {
            return json_encode(
                [
                    'resultCode' => 2,
                    'resultMessage' => '传递参数出错',
                ]
            );
        }

    }

    //获取文章分类列表

    public function articleCategoryList()
    {
        try {

            $result = DB::table('article')->distinct()->select('category')
                ->whereNull('deleted_at')->get();

            return json_encode(
                [
                    'resultCode' => 0,
                    'resultMessage' => '获取文章分类列表成功',
                    'data' => $result,
                ]
            );
        } catch (Exception $e) {
            return json_encode(
                [
                    'resultCode' => 2,
                    'resultMessage' => '传递参数出错',
                ]
            );
        }
    }

    //获取文章详情
    public function articleDetail(Request $request)
    {

        //$result = Article::find($request['id']);


        $result = DB::table('article')
            ->join('users', 'article.user_id', '=', 'users.id')
            ->select(
                'article.id as id', 'article.title', 'article.created_at',
                'article.updated_at', 'article.content', 'article.tags',
                'article.thumbnail', 'article.category', 'article.praise_count',
                'article.read_count', 'article.comment_count', 'users.name',
                'users.avatar'
            )
            ->where(
                [
                    ['article.id', '=', $request['id']],
                ]
            )->whereNull('article.deleted_at')
            ->get();

        $commentList = DB::table('article_comment')->where('article_id', '=', $request->id)->whereNull('deleted_at')->orderBy('id', 'desc')->get();

        if (count($result) > 0) {
            return json_encode(
                [
                    'resultCode' => 0,
                    'resultMessage' => '获取文章详情成功',
                    'data' => $result,
                    'commentList' => $commentList,
                ]
            );
        }

        return json_encode(
            [
                'resultCode' => 1,
                'resultMessage' => '获取文章详情失败',
            ]
        );
    }

    //更新
    public function addRead(Request $request)
    {

        $article = article::find($request['id']);

        $article['read_count'] = $article['read_count'] + 1;

        if ($article->save()) {
            return json_encode(
                [
                    'resultCode' => 0,
                    'resultMessage' => '阅读量更新成功',
                    'data' => []
                ]
            );

        }

        return json_encode(
            [
                'resultCode' => 1,
                'resultMessage' => '阅读量更新失败',
                'data' => []
            ]
        );
    }

    //更新
    public function addPraise(Request $request)
    {

        $article = article::find($request['id']);

        $article['praise_count'] = $article['praise_count'] + 1;

        if ($article->save()) {
            return json_encode(
                [
                    'resultCode' => 0,
                    'resultMessage' => '点赞成功',
                    'data' => []
                ]
            );

        }

        return json_encode(
            [
                'resultCode' => 1,
                'resultMessage' => '点赞失败',
                'data' => []
            ]
        );
    }


}
