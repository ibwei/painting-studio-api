<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;

class teacherController extends Controller
{
    //后台获取教师列表
    public function teacherList(Request $request)
    {
        if(property_exists($request,'pageSize')) {
            $pageSize = $request->pageSize;
            $pageNum = $request->pageNum;
            $result = DB::table('teacher')->skip($pageSize * ($pageNum - 1))->take(
                $pageSize
            )->whereNull('deleted_at')->orderBy('id', 'desc')->get();
            $count = teacher::all()->count();
        } else {
            $result = DB::table('teacher')->whereNull('deleted_at')->orderBy('id','desc')->get();
            $count = $result->count();
        }
        return json_encode(
            [
                'resultCode'    => 0,
                'resultMessage' => '获取教师列表成功',
                'data'          => $result,
                'total'         => $count,
            ]
        );
    }
    // 前端获取教师详情
    public function teacherDetail(Request $request)
    {
        $result = teacher::find($request['id']);
        return json_encode(
            [
                'resultCode'    => 0,
                'resultMessage' => '获取教师列表成功',
                'data'          => $result,
            ]
        );
    }

    // 前端获取教师列表
    public function list(Request $request)
    {
        $result = teacher::all();
        return json_encode(
            [
                'resultCode'    => 0,
                'resultMessage' => '获取教师列表成功',
                'data'          => $result,
            ]
        );
    }

    // 新增教师详情
    public function teacherAdd(Request $request)
    {

        $teacher          = new teacher;
        $teacher->name = $request->name;
        $teacher->photo = $request->photoUrl;
        $teacher->rate = $request->rate;
        $teacher->desc = $request->desc;
        $teacher->impression = $request->impression;
        $teacher->good_at = $request->good_at;
        if(property_exists($request,'deeds')) {

            $teacher->deeds = $request->deeds;
        }
        $teacher->save();

        return json_encode(
            [
                'resultCode'    => 0,
                'resultMessage' => '新增教师成功',
                'data'          => []
            ]
        );
    }

    // 编辑教师详情
    public function teacherUpdate(Request $request) {
        $teacher = teacher::find($request['id']);
        $teacher->name = $request->name;
        $teacher->photo = $request->photoUrl;
        $teacher->rate = $request->rate;
        $teacher->desc = $request->desc;
        $teacher->impression = $request->impression;
        $teacher->good_at = $request->good_at;
        $teacher->deeds = $request->deeds;
        if($teacher->save()) {
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
    public function teacherDelete(Request $request)
    {

        $teacher = teacher::find($request['id']);
        if ($teacher->delete()) {
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
