<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaintingStudio;

class PaintingStudioController extends Controller
{
    //

    //后台获取店铺信息
    public function paintingStudioList(Request $request)
    {


        $result = PaintingStudio::all();


        return json_encode(
            [
                'resultCode'    => 0,
                'resultMessage' => '获取画室信息成功',
                'data'          => $result,
            ]
        );
    }


    //前端获取店铺信息
    public function info(Request $request)
    {


        $result = PaintingStudio::all();

        if (count($result) > 0) {
            return json_encode(
                [
                    'resultCode'    => 0,
                    'resultMessage' => '获取画室信息成功',
                    'data'          => $result,
                ]
            );
        }

        return json_encode(
            [
                'resultCode'    => 1,
                'resultMessage' => '获取画室信息失败',
            ]
        );
    }


    //更新
    public function paintingStudioUpdate(Request $request)
    {

        $paintingStudio = paintingStudio::find($request['id']);


        $paintingStudio->wechat           = $request->wechat;
        $paintingStudio->logo             = $request->logo;
        $paintingStudio->phone            = $request->phone;
        $paintingStudio->name             = $request->name;
        $paintingStudio->qq               = $request->qq;
        $paintingStudio->email            = $request->email;
        $paintingStudio->er_code          = $request->er_code;
        $paintingStudio->address_location = $request->address_location;
        $paintingStudio->address          = $request->address;
        $paintingStudio->status           = $request['status'];


        if ($paintingStudio->save()) {
            return json_encode(
                [
                    'resultCode'    => 0,
                    'resultMessage' => '更新画室信息成功',
                    'data'          => []
                ]
            );
        }

        return json_encode(
            [
                'resultCode'    => 1,
                'resultMessage' => '更新画室信息失败',
            ]
        );


    }

    public function paintingStudioDelete(Request $request)
    {

        $paintingStudio = paintingStudio::find($request['id']);
        if ($paintingStudio->delete()) {
            return json_encode(
                [
                    'resultCode'    => 0,
                    'resultMessage' => '删除学生作品成功',
                    'data'          => []
                ]
            );
        }

        return json_encode(
            [
                'resultCode'    => 1,
                'resultMessage' => '删除学生作品失败',
                'data'          => []
            ]
        );

    }
}
