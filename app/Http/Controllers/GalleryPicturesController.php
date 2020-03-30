<?php

namespace App\Http\Controllers;

use App\Models\GalleryPictures;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class GalleryPicturesController extends Controller
{

    public function list(Request $request)
    {

        $result = DB::table('gallery_pictures')->take(12)->whereNull('deleted_at')->orderBy('id')->get();

        $count = GalleryPictures::all()->count();

        return json_encode(
            [
                'resultCode' => 0,
                'resultMessage' => '获取画廊图片成功',
                'data' => $result,
                'total' => $count,
            ]
        );
    }

    //新增画廊图片
    public function add(Request $request)
    {

        $galleryPictures = new GalleryPictures;
        $galleryPictures['url'] = $request['url'];
        $galleryPictures['name'] = $request['name'];
        $galleryPictures['desc'] = $request['desc'];


        if ($galleryPictures->save()) {

            return json_encode(
                [
                    'resultCode' => 0,
                    'resultMessage' => '新增画廊图片成功',
                    'data' => []
                ]
            );
        }

        return json_encode(
            [
                'resultCode' => 1,
                'resultMessage' => '新增画廊图片失败',
                'data' => []
            ]
        );
    }


    //更新
    public function update(Request $request)
    {

        $galleryPictures = galleryPictures::find($request['id']);

        $galleryPictures['url'] = $request['url'];
        $galleryPictures['name'] = $request['name'];
        $galleryPictures['desc'] = $request['desc'];

        if ($galleryPictures->save()) {


            return json_encode(
                [
                    'resultCode' => 0,
                    'resultMessage' => '画廊图片更新成功',
                ]
            );

        }

        return json_encode(
            [
                'resultCode' => 1,
                'resultMessage' => '画廊图片更新失败',
                'data' => []
            ]
        );
    }
}
