<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Activity;
use App\Models\Purchasecoursemeta;
use DB;

class PaymentExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
            $dateFrom = '';
            $dateTo = '';
            $subscription_id = '';
            $transaction_id = '';
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

            $records = DB::table('purchase_course_meta as pcm')->where('pcm.booking_status', 'completed')->join('purchase_course as pc', 'pcm.purchase_course_id', '=', 'pc.id');
        if($subscription_id){
            $records = $records->where('pcm.unique_id', $subscription_id);
        }

        if($dateFrom){
            $records = $records->where('pcm.purchase_date', '>=', $dateFrom);
        }

        if($dateTo){
            $records = $records->where('pcm.purchase_date', '<=', $dateTo);
        }

        if($transaction_id){
            $records = $records->where('pc.pg_tracking_id', $transaction_id);
        }

        if($institution){
            $records = $records->where('pcm.institution_id', $institution);
        }

        if($student){
            $records = $records->where('pcm.user_id', $student);
        }

        $records = $records->latest()->select('pcm.unique_id', 'pcm.user_id', 'pcm.institution_id', 'pcm.start_date', 'pcm.end_date', 'pc.pg_tracking_id', 'pcm.purchase_date', 'pcm.total_amount', 'pcm.created_at', 'pcm.course_id')->get();

        return view('reports.payment-excel', [
            'records' => $records
        ]);
    }
}
