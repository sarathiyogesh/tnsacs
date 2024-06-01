<?php

namespace App\Exports;

use App\Models\SeminarStudent;
use App\Models\Seminar;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class CustomerSalesExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
            $dateFrom = '2022-01-01';
            $dateTo = '';
            $search = '';
            if(isset($_GET['date_from']) && $_GET['date_from'] != '' && $_GET['date_from'] > $dateFrom){

                $dateFrom = date('Y-m-d', strtotime($_GET['date_from']));
            }

            if(isset($_GET['date_to']) && $_GET['date_to'] != ''){
                $dateTo = date('Y-m-d', strtotime($_GET['date_to']));
            }

            if(isset($_GET['search']) && $_GET['search'] != ''){
                $search = $_GET['search'];
            }

            $records = DB::table('bookingreports as b')->where('b.bookingStatus','confirmed')->orderBy('b.fullname', 'ASC')
                ->join('users as us', 'us.id', '=', 'b.userId');

            if($dateFrom != ''){
                $records = $records->where('b.bookingDate', '>=', $dateFrom );
            }

            if($dateTo != ''){
                $records = $records->where('b.bookingDate', '<=', $dateTo );
            }

            if($search != ''){
                $records = $records->where(function ($query) use ($search) {
                          $query->where('b.fullname', 'LIKE', '%'.$search.'%')
                          ->orWhere('b.email', 'LIKE', '%'.$search.'%');
                          });
            }
            $records = $records->select(DB::raw('SUM(b.totalPrice) as total_amount'), DB::raw("COUNT(*) as total_count"), 'b.userId', 'b.fullname', 'b.email', 'us.ca_status')->groupBy('b.userId', 'b.fullname', 'b.email')->get();

        return view('excel.salesby_customer_reports', [
            'records' => $records
        ]);
    }
}
