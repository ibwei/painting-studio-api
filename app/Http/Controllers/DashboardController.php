<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\BookSchedule;
use App\Models\CourseEnroll;
use App\Models\Feedback;
use App\Models\Statistics;
use App\Models\TeacherComment;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class DashboardController extends Controller
{
    //
    public function index()
    {

        $userCount = Users::where('status', '=', 1)->count();
        $loginTodayCount = Statistics::whereDate('created_at', date('Y-m-d'))->count();
        $feedbackCount = Feedback::where('status', '=', 0)->count();
        $feedbackCount1 = Feedback::where('status', '<>', 0)->count();
        $bookScheduleCount = BookSchedule::where('status', '=', 0)->count();
        $bookScheduleCount1 = BookSchedule::where('status', '<>', 0)->count();
        $teacherCommentCount = TeacherComment::where('status', '=', 0)->count();
        $teacherCommentCount1 = TeacherComment::where('status', '<>', 0)->count();
        $articleCommentCount = ArticleComment::where('status', '=', 0)->count();
        $articleCommentCount1 = ArticleComment::where('status', '<>', 0)->count();
        $courseEnrollCount = CourseEnroll::where('status', '=', 0)->count();
        $courseEnrollCount1 = CourseEnroll::where('status', '<>', 0)->count();
        return json_encode(
            [
                'resultCode' => 0,
                'resultMessage' => '请求看板数据成功',
                'data' => [
                    'CurrentWeek' => 5655,
                    'PreviousWeek' => 4356,
                    'actuals' => [3, 3, 1, 7, 5, 7, 6, 8, 5, 0, 9, 2],
                    'dataList' => [
                        ['name' => '今日登录', 'value' => $loginTodayCount, 'number' => $userCount],
                        ['name' => '未处理报名', 'value' => $courseEnrollCount, 'number' => $courseEnrollCount1],
                        ['name' => '未处理预约', 'value' => $bookScheduleCount, 'number' => $bookScheduleCount1],
                        ['name' => '未处理反馈', 'value' => $feedbackCount, 'number' => $feedbackCount1],
                        ['name' => '教师评论待审核', 'value' => $teacherCommentCount, 'number' => $teacherCommentCount1],
                        ['name' => '文章评论待审核', 'value' => $articleCommentCount, 'number' => $articleCommentCount1],
                    ],
                    'doughnut' => [38, 44, 44, 39],
                    'lineData' => [
                        'Current' => [41, 68, 70, 34, 60, 60, 74],
                        'Previous' => [49, 43, 61, 66, 37, 67, 41],
                    ],
                    'projections' => [0, 0, 0, 1, 3, 11, 4, 23, 12, 4, 2, 7],
                ]
            ]
        );
    }
}
