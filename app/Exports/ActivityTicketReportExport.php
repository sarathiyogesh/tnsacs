<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Activity;
use DB;

class ActivityTicketReportExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
            $activity = '';
            $search_filter = '';
            
            if(isset($_GET['search_filter']) && $_GET['search_filter'] != ''){
                $search_filter = $_GET['search_filter'];
            }

            if(isset($_GET['activity']) && $_GET['activity'] != ''){
                $activity = $_GET['activity'];
            }

            $records = DB::table('activity_ticket_item as ti')->orderBy('ti.activityId', 'ASC');

            if($activity != ''){
                $records = $records->where('ti.activityId', $activity);
            }

            if($search_filter != ''){
                $records = $records->join('activity as ac', 'ac.activity_id', '=', 'ti.activityId')->where('ac.activity_name', 'LIKE', '%'.$search_filter.'%')->orWhere('ti.item_name', 'LIKE', '%'.$search_filter.'%');
            }

            $records = $records->get();

                        $results = [];
            $i = 0;

            foreach($records as $record){
                $price_type = 'All age';
                if($record->price_type == 'adultandchild'){
                    $price_type = 'Adult and Child';
                }else if($record->price_type == 'adult' || $record->price_type == 'child'){
                    $price_type = ucfirst($record->price_type);
                }

                $minmax = '--/--';
                if($record->minimum_ticket && $record->maximum_ticket){
                    $minmax = $record->minimum_ticket.'/'.$record->maximum_ticket;
                }else if($record->minimum_ticket && !$record->maximum_ticket){
                    $minmax = $record->minimum_ticket.'/--';
                }else if(!$record->minimum_ticket && $record->maximum_ticket){
                    $minmax = '--/'.$record->maximum_ticket;
                }

                $getdates = DB::table('activity_ticket')->where('activityId',$record->activityId)->where('status','active')->first();
                $last_date = '--';
                if($getdates){
                    $dates = explode (",", $getdates->ticket_date);
                    if(is_array($dates) && count($dates) != 0){
                        $last_date = $dates[count($dates)-1];
                    }
                }

                $activity_name = str_replace('+', ' PLUS ', Activity::getactivityname($record->activityId));
                $activity_name = str_replace('&', ' AND ', $activity_name);

                $item_name = str_replace('+', ' PLUS ', $record->item_name);
                $item_name = str_replace('&', ' AND ', $item_name);

                $item_desc = str_replace('+', ' PLUS ', $record->item_desc);
                $item_desc = str_replace('&', ' AND ', $item_desc);

                $results[$i]['activity_name'] =$activity_name;
                $results[$i]['ticket_name'] = $item_name;
                $results[$i]['description'] = $item_desc;
                $results[$i]['price_type'] = $price_type;
                $results[$i]['adult_price'] = $record->adult_price;
                $results[$i]['child_price'] = $record->child_price;
                $results[$i]['allage_price'] = $record->allage_price;
                $results[$i]['adult1_price'] = $record->adult_price1;
                $results[$i]['child1_price'] = $record->child_price1;
                $results[$i]['allage1_price'] = $record->allage_price1;
                $results[$i]['minmax'] = $minmax;
                $results[$i]['last_date'] = $last_date;

                $i++;
            }

        return view('excel.activityticket_reports', [
            'results' => $results
        ]);
    }
}
