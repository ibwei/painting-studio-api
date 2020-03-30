<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Client;
use Socialite;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client as HttpClient;
use App\User;
use Illuminate\Http\Request;
use Validator;
use EasyWeChat\Factory;
use Ucpaas;

class UserController extends ApiController
{


    public function userLogin(Request $request)
    {
        return 'hehlo';
    }

    //获取用户的个人信息
    public function getUserInfo(Request $request)
    {
        return 'isOk';
    }


}
