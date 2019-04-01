<?php
/**
 * Created by PhpStorm.
 * User: yuse
 * Date: 19/3/31
 * Time: 下午9:25
 */
namespace App\Services;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UserService
{
    public function login($mobile,$password)
    {
        $user = DB::table('users2050_2019')->where('mobile',$mobile)->first();
        if ($user == null)
            return -1;
        if (!Hash::check($password,$user->password))
            return -2;
        else
            return $user->id;
    }

}