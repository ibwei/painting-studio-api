<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Environment;
use Illuminate\Support\Facades\DB;

class EnvironmentController extends Controller
{
    //后台获取列表列表
    public function environmentList(Request $request)
    {
        $pageSize = $request->pageSize;
        $pageNum  = $request->pageNum;


        $result = DB::table('environment')->skip($pageSize * ($pageNum - 1))
            ->take(
                $pageSize
            )->whereNull('deleted_at')->orderBy(
                'created_at', 'desc'
            )->get();

        $count = environment::all()->count();

        return json_encode(
            [
                'resultCode'    => 0,
                'resultMessage' => '获取画室环境列表成功',
                'data'          => $result,
                'total'         => $count,
            ]
        );
    }

    //前端获取画室环境列表
    public function EnvironmentFrontList(Request $request)
    {

        $start = $request['start'];
        $end = $request['end'];
        $result = DB::table('environment')->whereNull('deleted_at')->where('status', 1)->orderBy('order', 'desc')->orderBy(
            'created_at', 'desc'
        )->get();


        return json_encode(
            [
                'resultCode'    => 0,
                'resultMessage' => '获取画室环境列表成功',
                'data'          => $result,
            ]
        );
    }

    //新增画室环境
    public function EnvironmentAdd(Request $request)
    {

        $environment           = new environment;
        $environment->url      = $request->url;
        $environment->order    = $request->order;
        $environment->desc     = $request->desc;
        $environment->status = $request->status;
        $environment->save();

        return json_encode(
            [
                'resultCode'    => 0,
                'resultMessage' => '新增画室环境成功',
                'data'          => []
            ]
        );
    }


    //更新
    public function EnvironmentUpdate(Request $request)
    {

        $environment           = environment::find($request['id']);
        $environment->url      = $request->url;
        $environment->order    = $request->order;
        $environment->desc     = $request->desc;
        $environment->status   = $request->status;

        if ($environment->save()) {

            return json_encode(
                [
                    'resultCode'    => 0,
                    'resultMessage' => '更新画室环境成功',
                    'data'          => []
                ]
            );

        }

        return json_encode(
            [
                'resultCode'    => 1,
                'resultMessage' => '更新画室环境失败',
            ]
        );


    }

    public function EnvironmentDelete(Request $request) {

        $environment = environment::find($request['id']);
        if ($environment->delete()) {
            return json_encode(
                [
                    'resultCode'    => 0,
                    'resultMessage' => '删除画室环境成功',
                    'data'          => []
                ]
            );
        }

        return json_encode(
            [
                'resultCode'    => 1,
                'resultMessage' => '删除画室环境失败',
                'data'          => []
            ]
        );


    }
}
