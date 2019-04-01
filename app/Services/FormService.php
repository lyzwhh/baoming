<?php
/**
 * Created by PhpStorm.
 * User: yuse
 * Date: 19/3/31
 * Time: 下午9:58
 */

namespace App\Services;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FormService
{
    public function apply($applyInfo)
    {
        $time = Carbon::now();
        $info = array_merge($applyInfo,[
            'created_at' =>  $time,
            'updated_at'    =>  $time
        ]);
        DB::table('form')->insert($info);
    }

}