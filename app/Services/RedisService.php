<?php
/**
 * Create by PhpStorm
 * User: neuq-xjh
 * Date: 2019/10/6 0006
 * Time: 9:03
 */

namespace App\Service;


use Illuminate\Support\Facades\Redis;
use phpDocumentor\Reflection\Types\Boolean;

class RedisService
{
    private static $prefix;

    /**
     * 访问该类方法的入口，并初始化prefix属性
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        static::$prefix = env('REDIS_PREFIX', 'NEUQer');
        return static::$name(...$arguments);
    }

    // token默认过期时间为1天
    private static function setex(string $key, string $val, int $expireTime = 3600*24)
    {
        $key = static::$prefix . $key;
        Redis::setex($key, $expireTime, $val);
    }

    private static function exists(string $key)
    {
        return Redis::exists(static::$prefix . $key);
    }

    private static function get(string $key)
    {
       //dd(Redis::get(static::$prefix . $key));
        return Redis::get(static::$prefix . $key);
    }

    private static function mget(array $keys) {
        foreach ($keys as &$key) {
            $key = static::$prefix . $key;
        }

        return Redis::mget($keys);
    }

    private static function set(string $key, string $val)
    {
        Redis::set(static::$prefix . $key, $val);
    }

    private static function del(string $key)
    {
        Redis::del(static::$prefix . $key);
    }

    private static function ttl(string $key) {
        return Redis::ttl(static::$prefix . $key);
    }


    private static function delByLike(string $like)
    {
        $keys = Redis::keys(static::$prefix . "*$like*");
        foreach ($keys as $key) {
            Redis::del($key);
        }
    }

    //https://github.com/nrk/predis/blob/v1.1/examples/transaction_using_cas.php
    private static function transactionSetex($key,$pValue,$nValue,$expireTime = 3600*24)
    {
        $key = static::$prefix.$key;

        $options = array(
            'cas' => true,      // Initialize with support for CAS operations
            'watch' => $key,    // Key that needs to be WATCHed to detect changes
            'retry' => 3,       // Number of retries on aborted transactions, after
            // which the client bails out with an exception.
        );
        $flag = 0;
        Redis::transaction($options, function ($tx) use ($key,$pValue,$nValue,$expireTime,&$flag){
            $val = Redis::get($key);
            if ($val == $pValue)
            {
                Redis::setex($key,$expireTime,$nValue);
                $flag = 1;
            }
        });
        return $flag;
    }

    /*
     * set
     */
    private static function sadd($key, $val) {
        Redis::sadd(static::$prefix . $key, $val);
    }

    private static function sismember($key, $val) {
        return Redis::sismember(static::$prefix . $key, $val);
    }

    private static function scard($key) {
        return Redis::scard(static::$prefix . $key);
    }

    //sorted set
    /**
     * @param $key string 有序数组的键
     * @param $scoresAndMembers array 要插入的分数和成员 如: [0, "v1", 1, "v2"]
    */
    private static function zadd(string $key, array $scoresAndMembers) {
        Redis::zadd(static::$prefix . $key, ...$scoresAndMembers);
    }

    private static function zscan(string $key, int $cursor, string $pattern, int $count) {
        $data = Redis::zscan(static::$prefix . $key, $cursor, 'match', $pattern, 'count', $count);
        return $data;
    }

    //hash
    private static function hset(string $hash,string $key, string $val) {
        Redis::hset(static::$prefix . $hash, $key, $val);
    }

    private static function hget(string $hash,string $key) {
        return Redis::hget(static::$prefix . $hash, $key);
    }

    private static function hexists(string $hash,string $key) {
        return Redis::hexists(static::$prefix . $hash, $key);
    }

    private static function hdel(string $hash,string $key) {
        return Redis::hdel(static::$prefix . $hash, $key);
    }


}