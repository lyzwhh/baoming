<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FormService;

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
}
