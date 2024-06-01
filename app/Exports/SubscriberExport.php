<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Subscriber;
use DB;

class SubscriberExport implements FromView
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

            $records = Subscriber::latest();

            if($search != ''){
                $records = $records->where('email', 'LIKE', '%'.$search.'%');
            }
           
            $records = $records->get();
            
        return view('excel.subscribers', [
            'records' => $records
        ]);
    }
}
