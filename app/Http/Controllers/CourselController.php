<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coursel;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;
use Mail;

class CourselController extends Controller
{
    //
    //后台获取轮播图片列表
    public function courselList(Request $request)
    {
        if(property_exists($request,'pageSize')) {
            $pageSize = $request->pageSize;
            $pageNum = $request->pageNum;
            $result = DB::table('coursel')->skip($pageSize * ($pageNum - 1))->take(
                $pageSize
            )->whereNull('deleted_at')->orderBy('id', 'desc')->get();
            $count = coursel::all()->count();
        } else {
            $result = DB::table('coursel')->whereNull('deleted_at')->orderBy('id','desc')->get();
            $count = $result->count();
        }
        return json_encode(
            [
                'resultCode'    => 0,
                'resultMessage' => '获取图片轮播列表成功',
                'data'          => $result,
                'total'         => $count,
            ]
        );
    }
    // 前端获取轮播图片列表
    public function courselBannerList(Request $request)
    {
            $result = DB::table('coursel')->whereNull('deleted_at')->where('status',1)->orderBy('order', 'desc')->get();
            $count = coursel::all()->count();
        return json_encode(
            [
                'resultCode'    => 0,
                'resultMessage' => '获取图片轮播列表成功',
                'data'          => $result,
                'total'         => $count,
            ]
        );
    }

    // 新增轮播图
    public function courselAdd(Request $request)
    {

        $coursel          = new coursel;
        $coursel->url = $request->url;
        $coursel->desc = $request->desc;
        if(property_exists($request,'routerUrl')) {
            $coursel->routerUrl = $request->routerUrl;
        }
        $coursel->order = $request->order;
        $coursel->status = $request->status;
        $coursel->save();

        return json_encode(
            [
                'resultCode'    => 0,
                'resultMessage' => '新增成功',
                'data'          => []
            ]
        );
    }

    // 更新
    public function courselUpdate(Request $request) {
        $coursel = coursel::find($request['id']);
        $coursel->desc = $request->desc;
        $coursel->routerUrl = $request->routerUrl;
        $coursel->order = $request->order;
        $coursel->url = $request->url;
        $coursel->status = $request->status;
        if($coursel->save()) {
            return json_encode(
                [
                    'resultCode'    => 0,
                    'resultMessage' => '修改成功',
                    'data'          => []
                ]
            );
        }
        return json_encode(
            [
                'resultCode'    => 0,
                'resultMessage' => '修改失败',
                'data'          => []
            ]
        );
    }
    // 改变轮播状态
    public function courselUptateStatus(Request $request)
    {
        $coursel = coursel::find($request['id']);

        $coursel->status = $coursel->status == 0 ? 1 : 0;

        if ($coursel->save()) {
            return json_encode(
                [
                    'resultCode'    => 0,
                    'resultMessage' => '修改成功',
                    'data'          => []
                ]
            );
        }

        return json_encode(
            [
                'resultCode'    => 0,
                'resultMessage' => '修改失败',
                'data'          => []
            ]
        );
    }

    // 删除
    public function courselDelete(Request $request)
    {

        $coursel = coursel::find($request['id']);
        if ($coursel->delete()) {
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
