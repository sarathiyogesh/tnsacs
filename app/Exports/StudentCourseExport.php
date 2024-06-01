<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Activity;
use App\Models\Purchasecoursemeta;
use DB;

class StudentCourseExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
            $dateFrom = '';
            $dateTo = '';
            $subscription_id = '';
            $category = '';
            $institution = '';
            $student = '';
            
            if(isset($_GET['date_from']) && $_GET['date_from'] != ''){
                $dateFrom = date('Y-m-d', strtotime($_GET['date_from']));
            }

            if(isset($_GET['date_to']) && $_GET['date_to'] != ''){
                $dateTo = date('Y-m-d', strtotime($_GET['date_to']));
            }

            if(isset($_GET['subscription_id']) && $_GET['subscription_id'] != ''){
                $subscription_id = $_GET['subscription_id'];
            }

            if(isset($_GET['category']) && $_GET['category'] != ''){
                $category = $_GET['category'];
            }

            if(isset($_GET['institution']) && $_GET['institution'] != ''){
                $institution = $_GET['institution'];
            }

            if(isset($_GET['student']) && $_GET['student'] != ''){
                $student = $_GET['student'];
            }

            $records = Purchasecoursemeta::where('booking_status', 'completed')->where('purchase_type', 'student');
            if($subscription_id){
                $records = $records->where('unique_id', $subscription_id);
            }

            if($dateFrom){
                $records = $records->where('purchase_date', '>=', $dateFrom);
            }

            if($dateTo){
                $records = $records->where('purchase_date', '>=', $dateTo);
            }

            if($category){
                $records = $records->where('category', $category);
            }

            if($institution){
                $records = $records->where('institution_id', $institution);
            }

            if($student){
                $records = $records->where('user_id', $student);
            }

            $records = $records->latest()->get();

        return view('reports.student-course-excel', [
            'records' => $records
        ]);
    }
}
