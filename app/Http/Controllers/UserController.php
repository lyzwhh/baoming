<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tool\ValidationHelper;
use App\Services\UserService;
use App\Services\TokenService;

class userController extends Controller
{
    private $userService;
    private $tokenService;
    public function __construct(UserService $userService,
                                TokenService $tokenService)
    {
        $this->userService=$userService;
        $this->tokenService=$tokenService;
    }

    public function login(Request $request)
    {
        $this->validate($request,[
            'mobile'    =>  'required',
            'password'  =>  'required'
        ]);
        $loginData = $request->all();
        $userId = $this->userService->login($loginData['mobile'],$loginData['password']);
        if ($userId == -1)
        {
            return response()->json([
                'code'      =>  1002,
                'data'   =>  [
                    'message'   =>  '账号不存在'
                ]
            ]);
        }
        else if ($userId == -2)
        {

            return response()->json([
                'code'      =>  1001,
                'data'   =>  [
                    'message'   =>  '密码错误'
                ]
            ]);
        }
        else
        {
            $tokenStr = $this->tokenService->makeToken($userId);
            return response()->json([
                'code'      =>  0,
                'data'      =>  [
                    'message'   =>  'ok',
                    'token'  =>  $tokenStr
                ]
            ]);
        }
    }
}
