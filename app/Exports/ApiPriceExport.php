<?php

namespace App\Exports;

use App\Models\SeminarStudent;
use App\Models\Seminar;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Subscriber;
use DB;

class ApiPriceExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
            $search = '';
           
            
            if(isset($_GET['search']) && $_GET['search'] != ''){
                $search = $_GET['search'];
            }

            $records = DB::table('activity_buying_price_report');

            if($search != ''){
                $records = $records->where('activity_name', 'LIKE', '%'.$search.'%');
            }
           
            $records = $records->orderBy('activity_name', 'ASC')->get();
            
        return view('excel.apiprice', [
            'records' => $records
        ]);
    }
}
