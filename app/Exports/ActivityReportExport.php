<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Activity;
use DB;

class ActivityReportExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
            $activity_type = '';
            $status = '';
            $search_filter = '';
            
            if(isset($_GET['search_filter']) && $_GET['search_filter'] != ''){
                $search_filter = $_GET['search_filter'];
            }

            if(isset($_GET['activity_type']) && $_GET['activity_type'] != ''){
                $activity_type = $_GET['activity_type'];
            }

            if(isset($_GET['status']) && $_GET['status'] != ''){
                $status = $_GET['status'];
            }

            $records = Activity::orderBy('activity_id', 'ASC');

            if($activity_type != ''){
                $records = $records->where('ticket_source', $activity_type);
            }

            if($search_filter != ''){
                $records = $records->where('activity_name', 'LIKE', '%'.$search_filter.'%');
            }

            if($status != ''){
                $records = $records->where('activity_status', $status);
            }
            $records = $records->get();

            $results = [];
            $i = 0;
            foreach($records as $record){
                $status = ucfirst($record->activity_status);
                if($record->activity_status == 'hide'){
                    $status = 'Hidden';
                }
                $via = 'Manual';
                if($record->ticket_source == 'a'){
                    $via = "Rayna API";
                }else if($record->ticket_source == 'ph'){
                    $via = 'PrioHub API';
                }

                $getdates = DB::table('activity_ticket')->where('activityId',$record->activity_id)->where('status','active')->first();
                $last_date = '--';
                if($getdates){
                    $dates = explode (",", $getdates->ticket_date);
                    if(is_array($dates) && count($dates) != 0){
                        $last_date = $dates[count($dates)-1];
                    }
                }

                $activity_name = str_replace('+', ' PLUS ', $record->activity_name);
                $activity_name = str_replace('&', ' AND ', $activity_name);

                $results[$i]['name'] = $activity_name;
                $results[$i]['status'] = $status;
                $results[$i]['via'] = $via;
                $results[$i]['date'] = $last_date;
                $results[$i]['regular_price'] = $record->regular_price;
                $results[$i]['discount_price'] = $record->discount_price;
                $results[$i]['corporate_discount_price'] = $record->corporate_discount_price;
                $results[$i]['start_day'] = $record->starting_days;
                $i++;
            }

        return view('excel.activity_reports', [
            'results' => $results
        ]);
    }
}
