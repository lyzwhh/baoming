<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FormService;
use Maatwebsite\Excel\Excel;
use App\Exports\ExcelExport;
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

    public function getExcel(int $job,ExcelExport $excelExport)
    {
        $title = ['name','grade','college','specialty','qq','number', 'introduce'];
        $jobs = [
            1   =>  'FE',
            2   =>  'BE',
            3   =>  'Android',
            4   =>  'UI',
            5   =>  'PM',
            6   =>  'Operator'
        ];
        $fileName = $jobs[$job].'  baoming.xlsx';
        $excelExport->buildFormData($title,$job);
        return $excelExport->download($fileName);
    }

    public function applyTeam(Request $request)
    {
        $this->validate($request,[
//            'team_name'  =>  'required',
//            'leader'  =>  'required',
//            'qq0'  =>  'required',
//            'mobile0'  =>  'required',
//            'college0'  =>  'required',
//            'std_num0'  =>  'required',

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
    public function getTeamExcel(int $flag,ExcelExport $excelExport)
    {
        $title = ['flag','school_name','team_name','leader','qq0','sex0', 'mobile0','college0','std_num0'
                                                ,'member1','qq1','sex1','mobile1','college1','std_num1'
                                                ,'member2','qq2','sex2','mobile2','college2','std_num2'];
        $flags = [
            0   =>  'NEUQ-Live',
            1   =>  'Other-Live',
            2   =>  'Net'
        ];
        $fileName = $flags[$flag].'  turing.xlsx';
        $excelExport->buildTeamData($title,$flag);
        return $excelExport->download($fileName);
    }
}
