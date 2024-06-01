<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Activity;
use App\Models\Purchasecoursemeta;
use DB;

class CourseExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
            $dateFrom = '';
            $dateTo = '';
            $course = '';
            
            if(isset($_GET['date_from']) && $_GET['date_from'] != ''){
                $dateFrom = date('Y-m-d', strtotime($_GET['date_from']));
            }

            if(isset($_GET['date_to']) && $_GET['date_to'] != ''){
                $dateTo = date('Y-m-d', strtotime($_GET['date_to']));
            }

            if(isset($_GET['course']) && $_GET['course'] != ''){
                $course = $_GET['course'];
            }

            $records = Purchasecoursemeta::where('booking_status', 'completed');
            if($course){
                $records = $records->where('course_id', $course);
            }

            if($dateFrom){
                $records = $records->where('purchase_date', '>=', $dateFrom);
            }

            if($dateTo){
                $records = $records->where('purchase_date', '>=', $dateTo);
            }

            $records = $records->latest()->get();

        return view('reports.course-excel', [
            'records' => $records
        ]);
    }
}
