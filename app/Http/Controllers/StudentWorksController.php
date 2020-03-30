<?php

namespace App\Http\Controllers;

use App\Models\StudentWorks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentWorksController extends Controller
{

    //后台获取列表列表
    public function studentWorksList(Request $request)
    {
        $pageSize = $request->pageSize;
        $pageNum  = $request->pageNum;


        $result = DB::table('student_works')->skip($pageSize * ($pageNum - 1))
            ->take(
                $pageSize
            )->whereNull('deleted_at')->orderBy(
                'created_at', 'desc'
            )->get();

        $count = StudentWorks::all()->count();

        return json_encode(
            [
                'resultCode'    => 0,
                'resultMessage' => '获取学生作品列表成功',
                'data'          => $result,
                'total'         => $count,
            ]
        );
    }

    //前端获取学生作品列表
    public function list(Request $request)
    {

        $start = $request['start'];
        $end = $request['end'];
        $result = DB::table('student_works')->whereNull('deleted_at')->skip($start)->take($end-$start)->orderBy('order', 'desc')->orderBy(
                'created_at', 'desc'
            )->get();


        return json_encode(
            [
                'resultCode'    => 0,
                'resultMessage' => '获取学生作品列表成功',
                'data'          => $result,
            ]
        );
    }

    //新增学生作品
    public function studentWorksAdd(Request $request)
    {

        $studentWorks           = new studentWorks;
        $studentWorks->url      = $request->url;
        $studentWorks->order    = $request->order;
        $studentWorks->name     = $request->name;
        $studentWorks->desc     = $request->desc;
        $studentWorks->category = $request['category'];
        $studentWorks->tags     = $request['tags'];
        $studentWorks->save();

        return json_encode(
            [
                'resultCode'    => 0,
                'resultMessage' => '新增学生作品成功',
                'data'          => []
            ]
        );
    }


    //更新
    public function studentWorksUpdate(Request $request)
    {

        $studentWorks           = studentWorks::find($request['id']);
        $studentWorks->url      = $request->url;
        $studentWorks->order    = $request->order;
        $studentWorks->name     = $request->name;
        $studentWorks->desc     = $request->desc;
        $studentWorks->category = $request['category'];
        $studentWorks->tags     = $request['tags'];
        $studentWorks->status   = $request['status'];

        if ($studentWorks->save()) {

            return json_encode(
                [
                    'resultCode'    => 0,
                    'resultMessage' => '更新学生作品成功',
                    'data'          => []
                ]
            );

        }

        return json_encode(
            [
                'resultCode'    => 1,
                'resultMessage' => '更新学生作品失败',
            ]
        );


    }

    public function studentWorksDelete(Request $request) {

        $studentWorks = StudentWorks::find($request['id']);
        if ($studentWorks->delete()) {
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
