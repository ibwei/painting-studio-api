<?php
/**
 * Created by PhpStorm.
 * User: 白小唯
 * Date: 2019/12/15
 * Time: 3:56
 */
namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            if ( ! $user = JWTAuth::parseToken()->authenticate(
            )
            ) {  //获取到用户数据，并赋值给$user
                return response()->json(
                    [
                        'errcode' => 401,
                        'errmsg'  => '无此用户'

                    ], 401
                );
            }

            return $next($request);

        } catch (TokenExpiredException $e) {

            return response()->json(
                [
                    'err_code' => 401,
                    'errmsg'  => 'token 过期', //token已过期
                ],401
            );

        } catch (TokenInvalidException $e) {

            return response()->json(
                [
                    'err_code' => 401,
                    'err_msg'  => 'token 无效',  //token无效
                ],401
            );

        } catch (JWTException $e) {

            return response()->json(
                [
                    'err_code' => 401,
                    'err_msg'  => '缺少token', //token为空
                ],401
            );

        }
    }
}