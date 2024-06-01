<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Activity;
use DB;

class BookingReportExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
            $dateFrom = '';
            $dateTo = '';
            $user_type = '';
            $ticket_from = '';
            $corporate = '';
            
            if(isset($_GET['date_from']) && $_GET['date_from'] != ''){
                $dateFrom = date('Y-m-d', strtotime($_GET['date_from']));
            }

            if(isset($_GET['date_to']) && $_GET['date_to'] != ''){
                $dateTo = date('Y-m-d', strtotime($_GET['date_to']));
            }

            if(isset($_GET['user_type']) && $_GET['user_type'] != ''){
                $user_type = $_GET['user_type'];
            }

            if(isset($_GET['corporate']) && $_GET['corporate'] != ''){
                $corporate = $_GET['corporate'];
            }

            if(isset($_GET['ticket_from']) && $_GET['ticket_from'] != ''){
                $ticket_from = $_GET['ticket_from'];
            }

            $corporates = DB::table('corporates')->where('status', 1)->select('name','id')->get();
        $records = [];
        if($dateFrom != '' || $dateTo != '' || $user_type != '' || $ticket_from != ''){
            $records = DB::table('bookingreports as b')->where('b.bookingStatus','confirmed')->orderBy('b.id', 'DESC');

            if($dateFrom != ''){
                $records = $records->where('b.bookingDate', '>=', $dateFrom );
            }

            if($dateTo != ''){
                $records = $records->where('b.bookingDate', '<=', $dateTo );
            }

            if($user_type != ''){
                $records = $records->where('ca_status',$input['user_type']);
              }

              if($ticket_from != ''){
                $records = $records->where('ticket_from',$input['ticket_from']);
              }

              if($corporate != ''){
                $records = $records->where('ca_org_id',$input['corporate']);
              }

            $records = $records->join('bookingreportmeta as bm','bm.bookingreportId', '=', 'b.id');
            $records = $records->select('b.id as breportId', 'b.bookingId', 'b.fullname', 'b.email', 'b.bookingDate', 'bm.activityName', 'bm.sectionName', 'bm.itemName', 'bm.adultCount', 'bm.childCount', 'bm.allageCount', 'bm.adultPrice', 'bm.childPrice', 'bm.allagePrice', 'b.totalPrice', 'b.reference_no', 'bm.rayna_adult_price', 'bm.rayna_child_price', 'bm.rayna_allage_price', 'bm.rayna_total_price','b.pg_charge_ref_no', 'b.ca_status', 'b.ticket_from', 'bm.totalPrice as metaTotal', 'bm.id as metaId','b.ca_org_id')->orderBy('b.bookingDate', 'DESC')->get();
        }

        return view('excel.booking_reports', [
            'records' => $records
        ]);
    }
}
