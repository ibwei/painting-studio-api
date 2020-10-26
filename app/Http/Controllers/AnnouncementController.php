<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
    //后端获取招生简章
    public function getAnnouncement(Request $request)
    {

        $result = DB::table('announcement')->where('id',1)->get();
        return json_encode(
            [
                'resultCode' => 0,
                'resultMessage' => '获取招生简介成功',
                'data' => $result
            ]
        );
    }

    //后端获取文章
    public function getArticle(Request $request)
    {

        $result = DB::table('announcement')->where('id',$request['id'])->get();
        return json_encode(
            [
                'resultCode' => 0,
                'resultMessage' => '获取成功',
                'data' => $result
            ]
        );
    }



    // 编辑简介详情
    public function announcementUpdate(Request $request)
    {
        $announcement = announcement::find($request['id']);
        $announcement['content'] = $request['content'];
        $announcement->save();

        return json_encode(
            [
                'resultCode' => 0,
                'resultMessage' => '更新成功',
                'data' => $announcement
            ]
        );
    }

    // 删除
    public function announcementDelete(Request $request)
    {

        $announcement = announcement::find($request['id']);
        if ($announcement->delete()) {
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
