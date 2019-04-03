<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FormService;
use Excel;
use Illuminate\Support\Facades\DB;
class FormController extends Controller
{
    private $formService;
    public function __construct(FormService $formService)
    {
        $this->formService = $formService;
    }
    public function apply(Request $request)
    {
        $this->validate($request,[
            'name'  =>  'required',
            'grade'  =>  'required',
            'college'  =>  'required',
            'specialty'  =>  'required',
            'qq'  =>  'required',
            'station'  =>  'required',
            'introduce'  =>  'required',
            'number'  =>  'required'
        ]);
        $applyInfo = $request->all();
        $this->formService->apply($applyInfo);
        return response([
            'code'  =>  0
        ]);


    }

    public function getExcel(int $job)
    {
        $table = DB::table('form')->where('station',$job)->get();
        $title = ['name','grade','college','specialty','qq','number', 'introduce'];
        $all_data[] = $title;
//        $fileName = iconv('UTF-8','GBK','工作室招新');
        $jobs = [
            1   =>  'FE',
            2   =>  'BE',
            3   =>  'Android',
            4   =>  'UI',
            5   =>  'PM',
            6   =>  'Operator'
        ];
        $fileName = $jobs[$job].'  baoming';

        foreach ($table as $signal_data){
            $temp = [];
            foreach ($title as $key){
                $temp[] = $signal_data->$key;
            }
            $all_data[] = $temp;
        }

        Excel::create($fileName,function($excel) use ($all_data){
            $excel->sheet('Sheet 1',function($sheet) use($all_data){
                $sheet->rows($all_data);
            });
        })->export('xls');

        return response()->download(realpath(base_path('public')).$fileName,$fileName);
    }

    public function applyTeam(Request $request)
    {
        $this->validate($request,[
            'team_name'  =>  'required',
            'leader'  =>  'required',
            'qq0'  =>  'required',
            'mobile0'  =>  'required',
            'college0'  =>  'required',
            'std_num0'  =>  'required',

//            'member1'  =>  'required',
//            'qq1'  =>  'required',
//            'mobile1'  =>  'required',
//            'college1'  =>  'required',
//            'std_num1'  =>  'required',
//            'member2'  =>  'required',
//            'qq2'  =>  'required',
//            'mobile2'  =>  'required',
//            'college2'  =>  'required',
//            'std_num2'  =>  'required'
        ]);
        $applyInfo = $request->all();
        $this->formService->applyTeam($applyInfo);
        return response([
            'code'  =>  0
        ]);
    }
}
