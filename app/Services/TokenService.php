<?php
/**
 * Created by PhpStorm.
 * User: yuse
 * Date: 19/3/31
 * Time: 下午9:28
 */
namespace App\Services;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class TokenService
{
    public static $EXPIRE_TIME = 360;  //  若是 则 hours => 15days
    public function createToken($userId)
    {
        $tokenStr = md5(uniqid());
        $time = new Carbon();
        $outTime = new Carbon();
        $outTime->addHour(self::$EXPIRE_TIME);
        $data = [
            'user_id' => $userId,
            'updated_at' => $time,
            'created_at' => $time,
            'expires_at' => $outTime,
            'token' => $tokenStr,
        ];
        DB::table('tokens')->insert($data);
        return $tokenStr;
    }
    public function updateToken($userId)
    {
        $time = new Carbon();
        $outTime = new Carbon();
        $outTime->addHour(self::$EXPIRE_TIME);
        $tokenStr = md5(uniqid());
        $data = [
            'token' => $tokenStr,
            'updated_at' => $time,
            'expires_at' => $outTime
        ];
        DB::table('tokens')->where('user_id', $userId)->update($data);
        return $tokenStr;
    }
    public function makeToken($userId)
    {
        $tokenStr = DB::table('tokens')->where('user_id', $userId)->first();
        if ($tokenStr == null)
        {
            $tokenStr = $this->createToken($userId);
        }
        else
        {
            $tokenStr = $this->updateToken($userId);
        }
        return $tokenStr;
    }
    public function verifyToken($tokenStr)
    {
        $res = $this->getToken($tokenStr);
        if($res == null)
            return -1;
        else{
            $time = new Carbon();
            if ($res->expires_at > $time) {
                return 1;
            } else {
                return 0;
            }
        }
    }
    public function getToken($tokenStr)
    {
        return DB::table('tokens')->where('token',$tokenStr)->first();
    }

    public function getUserByToken($tokenStr)
    {
        $tokenInfo = $this->getToken($tokenStr);
        $userInfo=DB::table('users')->where('id',$tokenInfo->user_id)->select('id','mobile')->first();
        return $userInfo;
    }
}