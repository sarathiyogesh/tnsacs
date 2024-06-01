<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Eventbooking;
use App\Models\Eventbookingmeta;
use DB;

class EventReportExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
            $records = Eventbooking::orderBy('id', 'ASC');
            $records = $records->get();
            $results = [];
            $i = 0;
            foreach($records as $record){
                $results[$i]['order_id'] = $record->booking_id;
                $results[$i]['first_name'] = $record->first_name;
                $results[$i]['last_name'] = $record->last_name;
                $results[$i]['email'] = $record->email;
                $results[$i]['phonenumber'] = $record->phone;
                $results[$i]['total_amount'] = $record->total_amount;
                $results[$i]['booking_id'] = $record->booking_id;
                $i++;
            }

        return view('excel.event_report_excel', [
            'results' => $results
        ]);
    }
}
