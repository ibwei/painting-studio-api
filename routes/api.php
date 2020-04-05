<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::post('/user/login', 'AuthController@login');//登录
Route::post('/user/register', 'AuthController@register');//注册

// 需要token的路由 ----------------------------------

Route::group(
    ['middleware' => 'api.auth'], function () {

    Route::post('/user/getUserInfo', 'AuthController@getUserInfo');//获取用户信息
    Route::post('/user/logout', 'AuthController@logout');//退出
    Route::post('/user/list', 'AuthController@list');
    Route::post('/user/update', 'AuthController@update');
    Route::post('/user/delete', 'AuthController@delete');
    Route::post('/dashboard', 'DashboardController@index');//主板面信息


    //反馈模块
    Route::post(
        '/feedback/feedbackList', 'FeedbackController@feedbackList'
    );//获取反馈用户列表
    Route::post(
        '/feedback/feedbackUpdate', 'FeedbackController@feedbackUpdate'
    );//处理反馈消息
    Route::post(
        '/feedback/feedbackDelete', 'FeedbackController@feedbackDelete'
    );//删除反馈消息

    //课程报名表

    Route::post(
        '/courseEnroll/courseEnrollList',
        'CourseEnrollController@CourseEnrollList'
    );
    Route::post(
        '/courseEnroll/courseEnrollUpdate',
        'CourseEnrollController@CourseEnrollUpdate'
    );
    Route::post(
        '/courseEnroll/courseEnrollDelete',
        'CourseEnrollController@CourseEnrollDelete'
    );

    // 轮播图
    // 添加
    Route::post(
        '/coursel/courselAdd', 'CourselController@courselAdd'
    );
    // 编辑
    Route::post(
        '/coursel/courselUpdate', 'CourselController@courselUpdate'
    );
    // 删除
    Route::post(
        '/coursel/courselDelete', 'CourselController@courselDelete'
    );
    // 改变状态
    Route::post(
        '/coursel/courselUpdateStatus', 'CourselController@courselUptateStatus'
    );
    // 获取轮播列表
    Route::get(
        '/coursel/courselList', 'CourselController@courselList'
    );

    //文章表

    Route::post(
        '/article/articleAdd', 'ArticleController@articleAdd'
    );
    Route::post(
        '/article/articleUpdate', 'ArticleController@articleUpdate'
    );
    Route::post(
        '/article/articleDelete', 'ArticleController@articleDelete'
    );


    //学生作品表

    Route::post(
        '/studentWorks/studentWorksAdd',
        'StudentWorksController@studentWorksAdd'
    );
    Route::post(
        '/studentWorks/studentWorksUpdate',
        'StudentWorksController@studentWorksUpdate'
    );
    Route::post(
        '/studentWorks/studentWorksDelete',
        'StudentWorksController@studentWorksDelete'
    );
    Route::post(
        '/studentWorks/studentWorksList',
        'StudentWorksController@studentWorksList'
    );

    // 教师详情

    Route::post(
        '/teacher/teacherAdd',
        'teacherController@teacherAdd'
    );
    Route::post(
        '/teacher/teacherUpdate',
        'teacherController@teacherUpdate'
    );
    Route::post(
        '/teacher/teacherDelete',
        'teacherController@teacherDelete'
    );
    Route::post(
        '/teacher/teacherList',
        'teacherController@teacherList'
    );
    //画室信息表
    Route::post(
        '/paintingStudio/list',
        'PaintingStudioController@paintingStudioList'
    );

    Route::post(
        '/paintingStudio/update',
        'PaintingStudioController@paintingStudioUpdate'
    );
    Route::post(
        '/paintingStudio/delete',
        'PaintingStudioController@paintingStudioDelete'
    );

    //3D画廊图片

    Route::post(
        '/galleryPictures/update',
        'GalleryPicturesController@update'
    );
    Route::post(
        '/galleryPictures/add',
        'GalleryPicturesController@add'
    );
    //教室环境表

    Route::post(
        '/environment/environmentAdd',
        'EnvironmentController@EnvironmentAdd'
    );
    Route::post(
        '/environment/environmentUpdate',
        'EnvironmentController@EnvironmentUpdate'
    );
    Route::post(
        '/environment/environmentDelete',
        'EnvironmentController@EnvironmentDelete'
    );
    Route::post(
        '/environment/environmentList',
        'EnvironmentController@EnvironmentList'
    );
    //画室课程表

    Route::post(
        '/course/add',
        'CourseController@add'
    );
    Route::post(
        '/course/update',
        'CourseController@update'
    );
    Route::post(
        '/course/delete',
        'CourseController@delete'
    );
    Route::post(
        '/course/list',
        'CourseController@list'
    );

    Route::post(
        '/article/comment/add',
        'ArticleCommentController@add'
    );
    Route::post(
        '/article/comment/delete',
        'ArticleCommentController@delete'
    );
    Route::post(
        '/article/comment/list',
        'ArticleCommentController@list'
    );
    Route::post(
        '/article/comment/update',
        'ArticleCommentController@update'
    );

    // teacher

    Route::post(
        '/teacher/comment/add',
        'TeacherCommentController@add'
    );
    Route::post(
        '/teacher/comment/list',
        'TeacherCommentController@list'
    );
    Route::post(
        '/teacher/comment/update',
        'TeacherCommentController@update'
    );
    Route::post(
        '/teacher/comment/delete',
        'TeacherCommentController@delete'
    );

    Route::post(
        '/schedule/add',
        'ScheduleController@add'
    );
    Route::post(
        '/schedule/update',
        'ScheduleController@update'
    );
    Route::post(
        '/schedule/delete',
        'ScheduleController@delete'
    );

    Route::post(
        '/bookschedule/add',
        'BookScheduleController@add'
    );
    Route::post(
        '/bookschedule/update',
        'BookScheduleController@update'
    );
    Route::post(
        '/bookschedule/list',
        'BookScheduleController@list'
    );
    Route::post(
        '/bookschedule/delete',
        'BookScheduleController@delete'
    );
    Route::post(
        '/bookschedule/personalList',
        'BookScheduleController@personalList'
    );
    Route::post(
        '/bookschedule/detail',
        'BookScheduleController@detail'
    );

},


    //-----------------------------不需要token--------------------------

    //新增反馈
    Route::post(
        '/feedback/feedbackAdd', 'FeedbackController@feedbackAdd'
    ),
    //新增课程报名
    Route::post(
        '/courseEnroll/courseEnrollAdd',
        'CourseEnrollController@CourseEnrollAdd'
    ),

    //上传图片
    Route::post(
        '/image/upload', 'ImageController@upload'
    ),


    // 获取轮播列表
    Route::get(
        '/coursel/courselBannerList', 'CourselController@courselBannerList'
    ),

    //根据分类获取文章列表
    Route::post(
        '/article/list',
        'ArticleController@articleListByCategory'
    ),
    //获取文章列表
    Route::post(
        '/article/articleList', 'ArticleController@ArticleList'
    ),
    //获取文章分类
    Route::get(
        '/article/categoryList', 'ArticleController@articleCategoryList'
    ),
    //获取文章详情
    Route::post(
        '/article/detail', 'ArticleController@articleDetail'
    ),
    //文章阅读量+1
    Route::post(
        '/article/addRead', 'ArticleController@addRead'
    ),
    //文章点赞+1
    Route::post(
        '/article/addPraise', 'ArticleController@addPraise'
    ),
    //获取学生作品列表
    Route::get(
        '/studentWorks/list', 'StudentWorksController@list'
    ),
    //获取教师详情
    Route::post(
        '/teacher/detail', 'teacherController@teacherDetail'
    ),
    //获取教师列表
    Route::get(
        '/teacher/list', 'teacherController@list'
    ),
    //获取画室信息
    Route::post(
        '/paintingStudio/info', 'PaintingStudioController@info'
    ),
    //3D画廊列表
    Route::get(
        '/galleryPictures/list',
        'GalleryPicturesController@list'
    ),
    //网站点赞
    Route::post(
        '/praise/add', 'PraiseController@add'
    ),
    //画室环境列表
    Route::get(
        '/environment/list',
        'EnvironmentController@EnvironmentFrontList'
    ),
    //获取所有课程
    Route::get(
        '/course/all',
        'CourseController@frontList'
    ),
    // 用户登录统计
    Route::post(
        '/statistics/login',
        'StatisticsController@login'
    ),
    Route::post(
        '/statistics/logout',
        'StatisticsController@logout'
    ),
    Route::post(
        '/schedule/list',
        'ScheduleController@list'
    )

);
