<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;

class ExcelExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    private $data = [];
    public function collection()
    {
        //
        return new Collection($this->data);
    }

    public function buildFormData($title,$job)
    {
        $this->data []= $title;
        $table = DB::table('form')->where('station',$job)->get();

        foreach ($table as $signal_data){
            $temp = [];
            foreach ($title as $key){          //用title来筛选所需数据
                $temp[] = $signal_data->$key;
            }
            $this->data[] = $temp;
        }
    }
    public function buildTeamData($title,$flag)
    {
        $this->data []= $title;
        $table = DB::table('team')->where('flag',$flag)->get();

        foreach ($table as $signal_data){
            $temp = [];
            foreach ($title as $key){          //用title来筛选所需数据
                $temp[] = $signal_data->$key;
            }
            $this->data[] = $temp;
        }
    }

}
