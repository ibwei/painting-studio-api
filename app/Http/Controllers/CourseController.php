<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    //后台获取课程列表
    public function list(Request $request)
    {
        if(property_exists($request,'pageSize')) {
            $pageSize = $request->pageSize;
            $pageNum = $request->pageNum;
            $result = DB::table('course')->skip($pageSize * ($pageNum - 1))->take(
                $pageSize
            )->whereNull('deleted_at')->orderBy('id', 'desc')->get();
            $count = course::all()->count();
        } else {
            $result = DB::table('course')->whereNull('deleted_at')->orderBy('id','desc')->get();
            $count = $result->count();
        }
        return json_encode(
            [
                'resultCode'    => 0,
                'resultMessage' => '获取课程列表成功',
                'data'          => $result,
                'total'         => $count,
            ]
        );
    }

    // 前端获取课程列表
    public function frontList()
    {
        $result =  $result = DB::table('course')->whereNull('deleted_at')->orderBy('id','desc')->get()->groupBy('category');
        return json_encode(
            [
                'resultCode'    => 0,
                'resultMessage' => '获取课程列表成功',
                'data'          => $result,
            ]
        );
    }

    // 新增课程列表
    public function add(Request $request)
    {

        $course          = new Course;
        $course->name = $request->name;
        $course->url = $request->url;
        $course->order = $request->order;
        $course->category = $request->category;
        $course->tags = $request->tags;
        $course->desc = $request->desc;
        $course->tuition = $request->tuition;
        $course->valid_time = $request->valid_time;
        $course->teacher = $request->teacher;
        $course->status = $request->status;
        $course->save();

        return json_encode(
            [
                'resultCode'    => 0,
                'resultMessage' => '新增课程成功',
                'data'          => []
            ]
        );
    }

    // 编辑教师详情
    public function update(Request $request) {
        $course = course::find($request['id']);
        $course->name = $request->name;
        $course->url = $request->url;
        $course->order = $request->order;
        $course->category = $request->category;
        $course->tags = $request->tags;
        $course->desc = $request->desc;
        $course->tuition = $request->tuition;
        $course->valid_time = $request->valid_time;
        $course->teacher = $request->teacher;
        $course->status = $request->status;
        $course->save();

        if($course->save()) {
            return json_encode(
                [
                    'resultCode'    => 0,
                    'resultMessage' => '课程修改成功',
                    'data'          => []
                ]
            );
        }

        return json_encode(
            [
                'resultCode'    => 1,
                'resultMessage' => '课程修改失败',
                'data'          => []
            ]
        );

    }
    // 删除
    public function delete(Request $request)
    {

        $course = course::find($request['id']);
        if ($course->delete()) {
            return json_encode(
                [
                    'resultCode'    => 0,
                    'resultMessage' => '删除课程成功',
                    'data'          => []
                ]
            );
        }

        return json_encode(
            [
                'resultCode'    => 1,
                'resultMessage' => '删除课程失败',
                'data'          => []
            ]
        );


    }
}
